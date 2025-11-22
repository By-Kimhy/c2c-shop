<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Latest 20 published products with eager loaded relations
        $products = Product::with(['user','category'])
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->take(20)
            ->get();

        // send to frontend home view (resources/views/frontend/home.blade.php)
        return view('frontend.home.index', compact('products'));
    }
}
