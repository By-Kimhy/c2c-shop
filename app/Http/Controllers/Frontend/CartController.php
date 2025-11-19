<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService){ $this->cartService = $cartService; }

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart($request);
        $cart->load('items.product');
        return view('frontend.cart.index', compact('cart'));
    }

    // AJAX add
    public function add(AddToCartRequest $req)
    {
        $cart = $this->cartService->getCart($req);
        $product = Product::findOrFail($req->product_id);
        $this->cartService->add($cart,$product,(int)$req->quantity);
        return response()->json(['success'=>true,'cart_count'=>$cart->items()->count()]);
    }

    public function update(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);
        $this->cartService->updateItem($item, (int)$request->quantity);
        return redirect()->route('cart.index')->with('success','Cart updated');
    }

    public function remove(Request $request)
    {
        $item = CartItem::findOrFail($request->item_id);
        $item->delete();
        return back()->with('success','Item removed');
    }
}

