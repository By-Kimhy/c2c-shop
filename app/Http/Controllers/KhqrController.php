<?php
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Services\KhqrService;
// use App\Models\Payment;
// use Endroid\QrCode\QrCode;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Storage;
// use KHQR\BakongKHQR;
// use KHQR\Helpers\KHQRData;
// use KHQR\Models\IndividualInfo;

// class KhqrController extends Controller
// {
//     public function generateQrCode(Request $request)
//     {
//         // 1) Validate amount from request
//         $request->validate([
//             'amount' => 'required|numeric|min:0.01'
//         ]);

//         // 2) Get amount
//         $amount = (float) $request->amount;

//         // 3) Build KHQR payload
//         $individualInfo = new IndividualInfo(
//             bakongAccountID: 'kimhy_by@aclb',
//             merchantName: 'BY KIMHY',
//             merchantCity: 'PHNOM PENH',
//             currency: KHQRData::CURRENCY_KHR,
//             amount: $amount
//         );

//         $response = BakongKHQR::generateIndividual($individualInfo);
//         return response()->json($response);
//     }

//     public function checkTransactionByMD5(Request $request)
//     {
//         $md5 = $request->md5;

//         $bakongKhqr = new BakongKHQR('your-api-token-here');

//         $response = $bakongKhqr->checkTransactionByMD5($md5);

//         return response()->json($response);
//     }
// }


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KhqrService;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;

// optional Endroid classes - used if available
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class KhqrController extends Controller
{
    /**
     * Generate KHQR payload and return QR image URL (PNG saved or google chart fallback).
     *
     * Options:
     * - Provide order_id (preferred). Controller will use order->total.
     * - Or provide amount directly (for quick tests).
     */
    public function generateQrCode(Request $request)
    {
        $request->validate([
            'order_id' => 'nullable|integer|exists:orders,id',
            'amount' => 'nullable|numeric|min:0.01',
        ]);

        // Resolve amount: prefer order total for safety
        $amount = null;
        $order = null;
        if ($request->filled('order_id')) {
            $order = Order::find($request->order_id);
            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }
            $amount = (float) $order->total;
        } elseif ($request->filled('amount')) {
            $amount = (float) $request->amount;
        }

        if (is_null($amount) || $amount <= 0) {
            return response()->json(['error' => 'Invalid amount'], 422);
        }

        // Build payload using your KHQR lib (BakongKHQR)
        try {
            $individualInfo = new IndividualInfo(
                bakongAccountID: env('KHQR_MERCHANT_ID', 'kimhy_by@aclb'),
                merchantName: env('KHQR_MERCHANT_NAME', config('app.name', 'C2CShop')),
                merchantCity: env('KHQR_MERCHANT_CITY', 'Phnom Penh'),
                currency: KHQRData::CURRENCY_KHR,
                amount: $amount
            );

            // the library returns the KHQR payload string or structured data.
            $response = BakongKHQR::generateIndividual($individualInfo);

            // depending on lib, $response may be string or array; normalize to string payload
            $payload = is_string($response) ? $response : (string) (json_encode($response));
        } catch (\Throwable $e) {
            Log::error('KHQR generation failed: ' . $e->getMessage());
            return response()->json(['error' => 'KHQR generation failed', 'message' => $e->getMessage()], 500);
        }

        // Create payment record (pending)
        try {
            $providerRef = 'KHQR' . strtoupper(Str::random(10));
            $payment = Payment::create([
                'order_id'    => $order ? $order->id : null,
                'amount'      => $amount,
                'currency'    => 'KHR',
                'status'      => 'pending',
                'provider'    => 'KHQR',
                'provider_ref'=> $providerRef,
                'payload'     => json_encode(['khqr_payload' => $payload]),
            ]);
        } catch (\Throwable $e) {
            Log::error('Payment create failed: '.$e->getMessage());
            return response()->json(['error' => 'Payment record failed', 'message' => $e->getMessage()], 500);
        }

        // Now we want to return a QR image URL.
        // First attempt: use Endroid Builder (server-side PNG) if available.
        $qrUrl = null;
        try {
            if (class_exists(Builder::class)) {
                $result = Builder::create()
                    ->writer(new PngWriter())
                    ->data($payload)
                    ->encoding(new Encoding('UTF-8'))
                    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                    ->size(400)
                    ->margin(10)
                    ->build();

                $png = $result->getString(); // raw PNG bytes
                $filename = 'khqr-' . time() . '-' . Str::random(6) . '.png';
                $storePath = 'public/khqr/' . $filename;
                Storage::put($storePath, $png);
                $qrUrl = asset('storage/khqr/' . $filename);
            } else {
                // If Endroid Builder missing, fallback to PngWriter + QrCode usage (older Endroid)
                if (class_exists(PngWriter::class) && class_exists(\Endroid\QrCode\QrCode::class)) {
                    $qr = new \Endroid\QrCode\QrCode($payload);
                    // Some Endroid versions use ->setSize(); others don't.
                    // attempt to set size if method exists
                    if (method_exists($qr, 'setSize')) {
                        $qr->setSize(400);
                    }
                    $writer = new PngWriter();
                    $result = $writer->write($qr);
                    $png = $result->getString();
                    $filename = 'khqr-' . time() . '-' . Str::random(6) . '.png';
                    $storePath = 'public/khqr/' . $filename;
                    Storage::put($storePath, $png);
                    $qrUrl = asset('storage/khqr/' . $filename);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Endroid QR generation failed: '.$e->getMessage());
            // continue to fallback below
        }

        // Final fallback: use Google Chart API QR (no server PNG created)
        if (!$qrUrl) {
            // URL-encode payload and produce Google Chart QR URL:
            $encoded = rawurlencode($payload);
            $size = 400;
            $qrUrl = "https://chart.googleapis.com/chart?cht=qr&chs={$size}x{$size}&chl={$encoded}&chld=L|1";
            // Note: using Google Chart means an external request for the QR image at display time.
        }

        // save QR image URL into payment payload for future reference
        try {
            $payloadArr = $payment->payload ?? [];
            if (!is_array($payloadArr)) {
                $payloadArr = json_decode($payment->payload, true) ?: [];
            }
            $payloadArr['qr_url'] = $qrUrl;
            $payloadArr['khqr_payload'] = $payload;
            $payment->payload = $payloadArr;
            $payment->save();
        } catch (\Throwable $e) {
            Log::warning('Could not update payment payload with qr_url: '.$e->getMessage());
        }

        // Return JSON for frontend to display or redirect
        return response()->json([
            'success' => true,
            'payment_id' => $payment->id,
            'order_id' => $order ? $order->id : null,
            'amount' => $amount,
            'qr_url' => $qrUrl,
            'payload' => $payload,
        ]);
    }

    // Optional helper that checks a transaction using the KHQR lib
    public function checkTransactionByMD5(Request $request)
    {
        $request->validate(['md5' => 'required|string']);
        $md5 = $request->md5;
        try {
            $bakongKhqr = new BakongKHQR(env('KHQR_API_TOKEN', 'your-api-token-here'));
            $response = $bakongKhqr->checkTransactionByMD5($md5);
            return response()->json($response);
        } catch (\Throwable $e) {
            Log::error('checkTransaction failed: '.$e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
