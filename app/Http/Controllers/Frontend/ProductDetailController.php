<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function show($id, Request $request)
    {
        // eager load user, category and sellerProfile if available
        $product = Product::with(['user', 'category', 'user.sellerProfile'])->findOrFail($id);

        // related products: same category (exclude current), fallback to latest
        $related = Product::where('id', '!=', $product->id)
            ->when($product->category_id, function($q) use ($product) {
                $q->where('category_id', $product->category_id);
            })
            ->limit(8)
            ->get();

        return view('frontend..product.product-detail', compact('product', 'related'));
    }
}
