<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;

class SellerOrderController extends Controller
{
    public function show($id)
    {
        $order = Order::with(['items','payments','user'])->findOrFail($id);
        return view('frontend.seller.orders.show', compact('order'));
    }
}
