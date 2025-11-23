<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\KhqrService;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use KHQR\BakongKHQR;
use KHQR\Models\IndividualInfo;

class CheckoutController extends Controller
{
    protected KhqrService $khqr;

    public function __construct(KhqrService $khqr)
    {
        $this->khqr = $khqr;
    }

    /**
     * Show checkout page (cart summary).
     */
    public function index(Request $request)
    {
        $cart = session('cart', []);
        $items = collect($cart)->map(function ($item, $key) {
            return [
                'id' => $item['id'] ?? $key,
                'name' => $item['name'] ?? 'Product',
                'price' => (float) ($item['price'] ?? 0),
                'qty' => (int) ($item['qty'] ?? 1),
                'image' => $item['image'] ?? null,
                'line' => ((float) ($item['price'] ?? 0)) * ((int) ($item['qty'] ?? 1)),
            ];
        });

        $subtotal = $items->sum('line');

        return view('frontend.checkout.index', [
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * Process checkout: create order, order items, payment (KHQR) and redirect to QR page.
     * Fallback: accept cart_snapshot (base64 JSON) if session cart empty.
     */
    public function process(Request $request)
    {
        Log::info('checkout.process start', [
            'session_cart_count' => count(session('cart', [])),
            'cart_snapshot_present' => $request->filled('cart_snapshot')
        ]);

        // 1) Resolve cart: prefer session, fallback to posted snapshot
        $cart = session('cart', []);
        if (empty($cart) && $request->filled('cart_snapshot')) {
            try {
                $decoded = json_decode(base64_decode($request->input('cart_snapshot')), true);
                if (is_array($decoded)) {
                    $tmp = [];
                    foreach ($decoded as $k => $v) {
                        $key = $v['id'] ?? $k;
                        $tmp[$key] = [
                            'id' => $v['id'] ?? $key,
                            'name' => $v['name'] ?? ($v['title'] ?? 'Product'),
                            'price' => isset($v['price']) ? (float) $v['price'] : (float) ($v['unit_price'] ?? 0),
                            'qty' => isset($v['qty']) ? (int) $v['qty'] : (int) ($v['quantity'] ?? 1),
                            'image' => $v['image'] ?? ($v['images'][0] ?? null),
                        ];
                    }
                    $cart = $tmp;
                }
            } catch (\Throwable $e) {
                Log::warning('Invalid cart_snapshot: ' . $e->getMessage());
                $cart = [];
            }
        }

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty.');
        }

        $user = auth()->user();

        DB::beginTransaction();
        try {
            // 2) Create order (match your orders table)
            $order = new Order();
            $order->user_id = $user ? $user->id : null;
            $order->order_number = 'ORD-' . strtoupper(Str::random(10));
            $order->shipping_name = $request->input('shipping_name') ?? ($user->name ?? 'Customer');
            $order->shipping_phone = $request->input('shipping_phone') ?? ($user->phone ?? '000000000');
            $order->shipping_address = $request->input('shipping_address') ?? ($user->address ?? 'No address provided');
            $order->subtotal = 0;
            $order->shipping_fee = 0;
            $order->total = 0;
            $order->currency = 'KHR';
            $order->status = 'pending';
            $order->payment_method = $request->input('payment_method', 'khqr');
            $order->save();

            Log::info('DEBUG before saving items', ['order_id' => $order->id, 'cart_count' => count($cart)]);

            // 3) Insert order_items (match your order_items schema)
            foreach ($cart as $productId => $item) {
                $oi = new OrderItem();
                $oi->order_id = $order->id;
                $oi->product_id = $item['id'] ?? $productId;
                $oi->name = Str::limit($item['name'] ?? 'Product', 191);
                $oi->quantity = isset($item['qty']) ? (int) $item['qty'] : (int) ($item['quantity'] ?? 1);
                $oi->unit_price = isset($item['price']) ? (float) $item['price'] : (float) ($item['unit_price'] ?? 0);
                $oi->line_total = round($oi->unit_price * $oi->quantity, 2);
                $oi->save();
            }

            // 4) Recalculate subtotal/total
            $calculatedSubtotal = OrderItem::where('order_id', $order->id)->sum('line_total');
            $order->subtotal = $calculatedSubtotal;
            $order->shipping_fee = 0;
            $order->total = round($calculatedSubtotal + $order->shipping_fee, 2);
            $order->save();

            Log::info('Order totals recalculated', ['order_id' => $order->id, 'subtotal' => $order->subtotal, 'total' => $order->total]);

            // 5) Create payment and generate KHQR payload & QR image
            $providerRef = 'KHQR' . strtoupper(Str::random(10));
            $amount = (float) $order->total;

            if (app()->bound(KhqrService::class)) {
                $khqrService = app(KhqrService::class);
                $payload = $khqrService->buildPayload([
                    'gui' => env('KHQR_GUI', 'BK'),
                    'merchant_id' => env('KHQR_MERCHANT_ID', ''),
                    'merchant_name' => config('app.name'),
                    'merchant_city' => env('KHQR_MERCHANT_CITY', 'Phnom Penh'),
                    'mcc' => env('KHQR_MCC', '0000'),
                ], $amount, '116', '12', $providerRef);
            } else {
                $payload = json_encode([
                    'merchant' => env('KHQR_MERCHANT_ID', ''),
                    'merchant_name' => config('app.name'),
                    'amount' => $amount,
                    'ref' => $providerRef,
                ]);
            }

            // ---------- Defensive QR generation (replace your current Builder code) ----------
            $payload = $payload; // existing payload string
            $filename = 'khqr-' . time() . '-' . Str::random(6) . '.png';
            $storePath = 'public/khqr/' . $filename;
            $publicPath = 'storage/khqr/' . $filename;

            try {
                // Preferred: Endroid Builder (v4+)
                if (class_exists(\Endroid\QrCode\Builder\Builder::class) && method_exists(\Endroid\QrCode\Builder\Builder::class, 'create')) {
                    $result = \Endroid\QrCode\Builder\Builder::create()
                        ->writer(new \Endroid\QrCode\Writer\PngWriter())
                        ->data($payload)
                        ->encoding(new \Endroid\QrCode\Encoding\Encoding('UTF-8'))
                        ->errorCorrectionLevel(new \Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh())
                        ->size(400)
                        ->margin(10)
                        ->build();

                    $png = $result->getString();
                }
                // Fallback: some installs expose QrCode class + PngWriter (v3/v4 differences)
                elseif (class_exists(\Endroid\QrCode\QrCode::class) && class_exists(\Endroid\QrCode\Writer\PngWriter::class)) {
                    // v3/v4 style: create QrCode instance then writer->write()
                    $qr = new \Endroid\QrCode\QrCode($payload);
                    // if setSize exists on this QrCode instance, set size
                    if (method_exists($qr, 'setSize')) {
                        $qr->setSize(400);
                    }
                    $writer = new \Endroid\QrCode\Writer\PngWriter();
                    $result = $writer->write($qr);
                    // Some versions return a result object
                    if (method_exists($result, 'getString')) {
                        $png = $result->getString();
                    } else {
                        // Some old writer returns binary via ->writeString() or ->getString()
                        $png = is_string($result) ? $result : (method_exists($result, 'getString') ? $result->getString() : null);
                    }
                }
                // Ultimate fallback: try direct binary generation using QrCode->writeString()
                elseif (class_exists(\Endroid\QrCode\QrCode::class) && method_exists(\Endroid\QrCode\QrCode::class, 'writeString')) {
                    $qr = new \Endroid\QrCode\QrCode($payload);
                    if (method_exists($qr, 'setSize')) {
                        $qr->setSize(400);
                    }
                    $png = $qr->writeString();
                } else {
                    throw new \RuntimeException('No compatible Endroid QR classes found (Builder or QrCode). Run `composer require endroid/qr-code:^4.3` or adjust code.');
                }

                if (empty($png)) {
                    throw new \RuntimeException('QR generation returned empty binary.');
                }

                // persist PNG to storage
                Storage::put($storePath, $png);

            } catch (\Throwable $e) {
                // log and rethrow a clearer message to bubble up to your controller catch
                Log::error('QR generation error: ' . $e->getMessage(), ['exception' => $e]);
                throw $e; // it will be caught by outer try/catch and show helpful message
            }
            // ---------- end defensive QR generation ----------


            // save payment
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $amount,
                'currency' => 'KHR',
                'status' => 'pending',
                'provider' => 'KHQR',
                'provider_ref' => $providerRef,
                'payload' => json_encode([
                    'khqr_payload' => $payload,
                    'qr_image' => $publicPath,
                ]),
            ]);

            // save payment
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $amount,
                'currency' => 'KHR',
                'status' => 'pending',
                'provider' => 'KHQR',
                'provider_ref' => $providerRef,
                'payload' => json_encode([
                    'khqr_payload' => $payload,
                    'qr_image' => $publicPath,
                ]),
            ]);

            DB::commit();

            // clear cart after successful order creation
            session()->forget('cart');

            // redirect to a QR view
            return redirect()->route('checkout.khqr.show', $order->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('checkout.process failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // return with error message so the cart view can show it
            return redirect()->route('cart.index')->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    /**
     * Show KHQR image / payload for an order
     */
    public function showKhqr($orderId)
    {
        $order = Order::with('payments')->findOrFail($orderId);

        // latest payment
        $payment = Payment::where('order_id', $order->id)->latest('id')->first();

        $payload = null;
        $qrDataUri = null;

        if ($payment && $payment->payload) {
            // normalize payload (Payment casts might already return array)
            $data = is_array($payment->payload) ? $payment->payload : @json_decode($payment->payload, true);
            $data = is_array($data) ? $data : [];

            // primary payload candidate keys
            $payload = $data['khqr_payload'] ?? $data['payload'] ?? $data['qr_text'] ?? $data['raw'] ?? null;

            // if not present, maybe the khqr payload itself was saved raw in DB (string)
            if (!$payload && is_string($payment->payload)) {
                $payload = $payment->payload;
            }
        }

        // Build an in-memory PNG & data URI if we have a payload
        if ($payload) {
            try {
                // Use Endroid Builder to create PNG bytes in memory
                $result = Builder::create()
                    ->writer(new PngWriter())
                    ->data($payload)
                    ->encoding(new Encoding('UTF-8'))
                    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                    ->size(400)
                    ->margin(10)
                    ->build();

                $png = $result->getString(); // raw PNG bytes
                $qrDataUri = 'data:image/png;base64,' . base64_encode($png);
            } catch (\Throwable $e) {
                // If Endroid isn't available or fails, fall back to Google Charts QR
                Log::warning('QR generation failed, falling back to Google Chart: ' . $e->getMessage());
                $encoded = rawurlencode($payload);
                $qrDataUri = "https://chart.googleapis.com/chart?cht=qr&chs=400x400&chl={$encoded}&chld=L|1";
            }
        }

        // If still nothing, leave payload null and view will show message
        return view('frontend.checkout.khqr', [
            'order' => $order,
            'payment' => $payment,
            'payload' => $payload,
            'qrDataUri' => $qrDataUri,
        ]);
    }
}
