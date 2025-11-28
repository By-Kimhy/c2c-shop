<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use App\Models\Payment;
use App\Models\Order;
use App\Mail\PaymentSuccessMail;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;

class KhqrController extends Controller
{
    /**
     * Generate KHQR payload using posted amount or order_id.
     * Returns JSON { success, qr_string, md5, qr_data_url, payment_id }
     */
    public function generateQrCode(Request $request)
    {
        $request->validate([
            'order_id' => 'nullable|integer|exists:orders,id',
            'amount' => 'nullable|numeric|min:0.01',
        ]);

        // Resolve token
        $token = env('KHQR_API_TOKEN');
        if (empty($token)) {
            return response()->json(['success' => false, 'message' => 'KHQR API token not configured.'], 500);
        }

        // Prefer order total if provided
        $amount = null;
        $order = null;
        if ($request->filled('order_id')) {
            $order = Order::find($request->input('order_id'));
            $amount = (float) $order->total;
        } elseif ($request->filled('amount')) {
            $amount = (float) $request->input('amount');
        }

        if (is_null($amount) || $amount <= 0) {
            return response()->json(['success' => false, 'message' => 'Invalid amount'], 422);
        }

        try {
            $individualInfo = new IndividualInfo(
                bakongAccountID: env('KHQR_MERCHANT_ID', 'kimhy_by@aclb'),
                merchantName: env('KHQR_MERCHANT_NAME', config('app.name', 'BY KIMHY')),
                merchantCity: env('KHQR_MERCHANT_CITY', 'PHNOM PENH'),
                currency: KHQRData::CURRENCY_KHR,
                amount: number_format($amount, 2, '.', '')
            );

            // Use SDK
            $response = BakongKHQR::generateIndividual($individualInfo);

            // Extract payload and md5
            $qrString = $response->data['qr'] ?? null;
            $md5 = $response->data['md5'] ?? null;

            if (!$qrString) {
                Log::error('KHQR returned no qr string', ['resp' => $response]);
                return response()->json(['success' => false, 'message' => 'KHQR did not return QR payload'], 500);
            }

            // Build in-memory PNG using Endroid Builder if available, else send payload only
            $qrDataUrl = null;
            try {
                if (class_exists(\Endroid\QrCode\Builder\Builder::class)) {
                    $result = \Endroid\QrCode\Builder\Builder::create()
                        ->writer(new \Endroid\QrCode\Writer\PngWriter())
                        ->data($qrString)
                        ->encoding(new \Endroid\QrCode\Encoding\Encoding('UTF-8'))
                        ->errorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
                        ->size(350)
                        ->margin(10)
                        ->build();
                    $png = $result->getString();
                    $qrDataUrl = 'data:image/png;base64,' . base64_encode($png);
                }
            } catch (\Throwable $e) {
                Log::warning('Could not build Endroid QR PNG: ' . $e->getMessage());
                $qrDataUrl = null;
            }

            // Optionally create payment record (if order provided)
            $payment = null;
            if ($order) {
                $providerRef = 'KHQR' . strtoupper(Str::random(10));

                // Save md5 into dedicated column as well as payload for robustness
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $amount,
                    'currency' => 'KHR',
                    'status' => 'pending',
                    'provider' => 'KHQR',
                    'provider_ref' => $providerRef,
                    'payload' => json_encode(['khqr_payload' => $qrString, 'md5' => $md5]),
                    'md5' => $md5,
                ]);
            }

            return response()->json([
                'success' => true,
                'qr' => $qrString,
                'md5' => $md5,
                'qr_data_url' => $qrDataUrl,
                'payment_id' => $payment ? $payment->id : null,
            ]);
        } catch (\KHQR\Exceptions\KHQRException $ke) {
            Log::error('KHQRException generateQrCode: ' . $ke->getMessage(), ['exception' => $ke]);
            return response()->json(['success' => false, 'message' => 'KHQR error: ' . $ke->getMessage()], 500);
        } catch (\Throwable $e) {
            Log::error('generateQrCode failed: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Check a transaction by MD5 and mark related payment & order as paid.
     * POST { md5: "..." }
     *
     * This version will also attempt to send a PaymentSuccessMail once.
     */
    public function checkMd5(Request $request)
    {
        $request->validate(['md5' => 'required|string']);
        $md5 = $request->input('md5');

        $token = env('KHQR_API_TOKEN');
        if (empty($token)) {
            return response()->json(['ok' => false, 'message' => 'KHQR API token not configured.'], 500);
        }

        try {
            $client = new BakongKHQR($token);
            $resp = $client->checkTransactionByMD5($md5);

            // Normalise success check depending on SDK structure
            $providerOk = false;
            if (is_array($resp) && isset($resp['responseCode']) && $resp['responseCode'] == 0) {
                $providerOk = true;
            }
            if (is_object($resp) && isset($resp->status) && is_array($resp->status) && ($resp->status['code'] ?? null) === 0) {
                $providerOk = true;
            }

            if (!$providerOk) {
                return response()->json(['ok' => false, 'message' => 'Provider returned non-success status', 'provider' => $resp], 200);
            }

            // Prefer md5 column first (fast & indexable). Fallback to JSON payload lookup, then to full scan.
            $payment = Payment::where('md5', $md5)->latest('id')->first();

            if (!$payment) {
                try {
                    $payment = Payment::where('payload->md5', $md5)->latest('id')->first();
                } catch (\Throwable $e) {
                    Log::warning('JSON payload lookup failed (maybe DB does not support JSON path). Falling back to manual scan.', ['error' => $e->getMessage()]);
                    // last-resort: scan records (inefficient but safe)
                    $payment = Payment::get()->reverse()->first(function ($p) use ($md5) {
                        $d = @json_decode($p->payload, true);
                        return is_array($d) && (($d['md5'] ?? null) === $md5);
                    });
                }
            }

            if (!$payment) {
                return response()->json(['ok' => false, 'message' => 'Payment record not found for this md5', 'provider' => $resp], 200);
            }

            // Mark as paid (idempotent)
            $wasChanged = false;
            if ($payment->status !== \App\Models\Payment::STATUS_PAID && $payment->status !== 'paid') {
                $payment->status = \App\Models\Payment::STATUS_PAID ?? 'paid';
                $payment->paid_at = now();
                $payment->save();
                $wasChanged = true;
            }

            $order = $payment->order;
            if ($order && $order->status !== 'paid') {
                $order->status = 'paid';
                $order->save();
                $wasChanged = true;
            }

            // Send email once (idempotent). Use orders.email_sent column if it exists.
            if ($order && !empty($order->email)) {
                $emailSentColumnExists = Schema::hasColumn('orders', 'email_sent');

                // If column exists and already true, skip sending.
                $alreadySent = $emailSentColumnExists ? (bool) $order->email_sent : false;

                if (!$alreadySent) {
                    // ---- SYNCHRONOUS SEND WITH FALLBACK ----
                    try {
                        // Try send immediately (blocking). This avoids requiring `php artisan queue:work`.
                        Mail::to($order->email)->send(new PaymentSuccessMail($order));
                        Log::info("Payment email sent synchronously for order {$order->id} to {$order->email}");
                    } catch (\Throwable $mailEx) {
                        // If sync fail (SMTP issue, timeout), log and attempt queue fallback.
                        Log::error("Failed to send PaymentSuccessMail synchronously for order {$order->id}: " . $mailEx->getMessage(), ['order_id' => $order->id, 'exception' => $mailEx]);

                        // Optional fallback: queue for later if queue configured.
                        try {
                            Mail::to($order->email)->queue(new PaymentSuccessMail($order));
                            Log::info("Payment email queued as fallback for order {$order->id} to {$order->email}");
                        } catch (\Throwable $qe) {
                            Log::warning("Fallback queuing also failed for order {$order->id}: " . $qe->getMessage(), ['order_id' => $order->id]);
                        }
                    }
                    // ---- END SEND LOGIC ----

                    // Mark email_sent column if present to avoid duplicates
                    if ($emailSentColumnExists) {
                        try {
                            $order->email_sent = true;
                            $order->save();
                        } catch (\Throwable $e) {
                            Log::warning('Failed to mark orders.email_sent for order '.$order->id.': '.$e->getMessage());
                        }
                    }
                }
            }

            return response()->json([
                'ok' => true,
                'message' => 'Payment marked paid',
                'payment_id' => $payment->id,
                'order_id' => $order->id ?? null
            ], 200);
        } catch (\KHQR\Exceptions\KHQRException $kex) {
            Log::error('KHQRException in checkMd5: ' . $kex->getMessage(), ['md5' => $md5]);
            return response()->json(['ok' => false, 'message' => 'KHQR error: ' . $kex->getMessage()], 500);
        } catch (\Throwable $e) {
            Log::error('Error in checkMd5: ' . $e->getMessage(), ['md5' => $md5]);
            return response()->json(['ok' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}
