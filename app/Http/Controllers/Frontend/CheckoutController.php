<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CheckoutController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService){ $this->cartService=$cartService; }

    public function show(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        $cart->load('items.product');
        return view('frontend.checkout.show', compact('cart'));
    }

    public function process(CheckoutRequest $req)
    {
        $cart = $this->cartService->getCart($req);
        $cart->load('items.product');

        // compute totals server-side
        $subtotal = $cart->items->sum(fn($i)=>$i->line_total);
        $shipping = 0;
        $total = $subtotal + $shipping;

        // create order
        $order = Order::create([
            'user_id'=>auth()->id(),
            'cart_id'=>$cart->id,
            'order_number'=>$this->generateOrderNumber(),
            'subtotal'=>$subtotal,
            'shipping_fee'=>$shipping,
            'total'=>$total,
            'currency'=>'KHR',
            'status'=>'pending',
            'payment_method'=>$req->payment_method,
            'shipping_name'=>$req->shipping_name,
            'shipping_phone'=>$req->shipping_phone,
            'shipping_address'=>$req->shipping_address,
        ]);

        // copy items
        foreach($cart->items as $item){
            $order->items()->create([
                'product_id'=>$item->product_id,
                'name'=>$item->product->name,
                'quantity'=>$item->quantity,
                'unit_price'=>$item->unit_price,
                'line_total'=>$item->line_total,
            ]);
        }

        // create payment record
        $payment = Payment::create([
            'order_id'=>$order->id,
            'amount'=>$order->total,
            'currency'=>$order->currency,
            'status'=>'pending',
            'provider'=>'khqr'
        ]);

        // render invoice HTML and save
        $invoiceHtml = app(\App\Services\InvoiceService::class)->renderHtml($order);
        $order->invoice_html = $invoiceHtml;
        $order->save();

        // fire OrderPlaced event (listeners queued)
        event(new \App\Events\OrderPlaced($order));

        // redirect to KHQR payment page (where QR is shown)
        return redirect()->route('khqr.show', ['order_number'=>$order->order_number]);
    }

    protected function generateOrderNumber()
    {
        return 'KHM-'.now()->format('Ym').'-'.Str::upper(Str::random(8));
    }
}


