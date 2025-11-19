<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::query()->where('status','published');

        // filter: category
        if($request->filled('category')){
            $q->whereHas('category', fn($b)=>$b->where('slug',$request->category));
        }
        // filter: price range "min-max"
        if($request->filled('price')){
            [$min,$max] = explode('-', $request->price) + [0,999999999];
            $q->whereBetween('price', [(float)$min, (float)$max]);
        }

        $products = $q->orderBy('created_at','desc')->paginate(12)->withQueryString();
        $categories = Category::all();
        return view('frontend.catalog.index', compact('products','categories'));
    }
}