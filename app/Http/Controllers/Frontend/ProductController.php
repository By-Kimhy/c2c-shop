<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug',$slug)->where('status','published')->firstOrFail();
        return view('frontend.products.show', compact('product'));
    }
}
