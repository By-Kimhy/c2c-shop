<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartService
{
    // Get or create cart for current session/user
    public function getCart(Request $request): Cart
    {
        if(auth()->check()){
            $cart = Cart::firstOrCreate(['user_id'=>auth()->id()]);
        } else {
            $token = $request->session()->get('cart_token') ?? Str::uuid();
            $request->session()->put('cart_token',$token);
            $cart = Cart::firstOrCreate(['session_token'=>$token]);
        }
        return $cart;
    }

    // Add product (server-side price)
    public function add(Cart $cart, Product $product, int $qty)
    {
        $item = $cart->items()->where('product_id',$product->id)->first();
        $unit = $product->price;
        if($item){
            $item->quantity += $qty;
            $item->unit_price = $unit;
            $item->line_total = $item->quantity * $unit;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id'=>$product->id,
                'quantity'=>$qty,
                'unit_price'=>$unit,
                'line_total'=>$qty*$unit,
            ]);
        }
        return $cart->refresh();
    }

    public function updateItem(CartItem $item, int $qty)
    {
        $item->quantity = $qty;
        $item->line_total = $qty * $item->unit_price;
        $item->save();
        return $item;
    }
}
