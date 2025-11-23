<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class CheckoutController extends Controller
{
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
        return view('frontend.checkout.index', compact('items', 'subtotal'));
    }

    public function process(Request $request)
    {
        // ensure POST (route already enforces)
        $cart = session('cart', []);
        if (empty($cart) && $request->filled('cart_snapshot')) {
            $cart = json_decode(base64_decode($request->input('cart_snapshot')), true) ?: [];
        }
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty.');
        }

        DB::beginTransaction();
        try {
            $user = auth()->user();
            $order = new Order();
            $order->user_id = $user ? $user->id : null;
            $order->order_number = 'ORD-' . strtoupper(Str::random(8));
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

            foreach ($cart as $k => $item) {
                $oi = new OrderItem();
                $oi->order_id = $order->id;
                $oi->product_id = $item['id'] ?? $k;
                $oi->name = Str::limit($item['name'] ?? 'Product', 191);
                $oi->quantity = (int) ($item['qty'] ?? 1);
                $oi->unit_price = (float) ($item['price'] ?? 0);
                $oi->line_total = round($oi->unit_price * $oi->quantity, 2);
                $oi->save();
            }

            $subtotal = OrderItem::where('order_id', $order->id)->sum('line_total');
            $order->subtotal = $subtotal;
            $order->shipping_fee = 0;
            $order->total = round($subtotal + $order->shipping_fee, 2);
            $order->save();

            // Build KHQR request using SDK
            $token = env('KHQR_API_TOKEN');
            if (empty($token))
                throw new \Exception('KHQR API token not configured.');

            $individualInfo = new IndividualInfo(
                bakongAccountID: env('KHQR_MERCHANT_ID', 'kimhy_by@aclb'),
                merchantName: env('KHQR_MERCHANT_NAME', config('app.name', 'BY KIMHY')),
                merchantCity: env('KHQR_MERCHANT_CITY', 'PHNOM PENH'),
                currency: KHQRData::CURRENCY_KHR,
                amount: number_format($order->total, 2, '.', '')
            );

            $khqrResponse = BakongKHQR::generateIndividual($individualInfo);

            if (!isset($khqrResponse->data['qr'])) {
                throw new \Exception('KHQR generation failed or returned no QR payload');
            }

            $qrString = $khqrResponse->data['qr']; // the KHQR string
            $md5 = $khqrResponse->data['md5'] ?? null;
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $amount,
                'currency' => 'KHR',
                'status' => 'pending',
                'provider' => 'KHQR',
                'provider_ref' => $providerRef,
                'payload' => json_encode([
                    'khqr_payload' => $qrString,
                    'md5' => $md5,
                ]),
            ]);

            // Build in-memory PNG
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data($qrString)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(350)
                ->margin(10)
                ->build();

            $png = $result->getString();
            $qrData = base64_encode($png);

            // Save payment
            $providerRef = 'KHQR' . strtoupper(Str::random(10));
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total,
                'currency' => 'KHR',
                'status' => 'pending',
                'provider' => 'KHQR',
                'provider_ref' => $providerRef,
                'payload' => json_encode(['khqr_payload' => $qrString, 'md5' => $md5]),
            ]);

            DB::commit();

            // clear cart
            session()->forget('cart');

            // Return view with inline image and md5
            return view('frontend.checkout.khqr', [
                'order' => $order,
                'payment' => $payment,
                'qrData' => $qrData,
                'qrRaw' => $qrString,
                'md5' => $md5,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('checkout.process error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('cart.index')->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    public function showKhqr($orderId)
    {
        $order = Order::findOrFail($orderId);
        $payment = $order->payments()->latest('id')->first();
        $qrData = null;
        $payload = null;
        if ($payment && $payment->payload) {
            $data = is_array($payment->payload) ? $payment->payload : (json_decode($payment->payload, true) ?: []);
            $payload = $data['khqr_payload'] ?? null;
            if ($payload) {
                $result = Builder::create()
                    ->writer(new PngWriter())
                    ->data($payload)
                    ->encoding(new Encoding('UTF-8'))
                    ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                    ->size(350)
                    ->margin(10)
                    ->build();
                $qrData = base64_encode($result->getString());
            }
        }
        return view('frontend.checkout.khqr', compact('order', 'payment', 'qrData', 'payload'));
    }
}
