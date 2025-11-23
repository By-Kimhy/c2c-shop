<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Show product listing (used by your product index view)
    public function index(Request $request)
    {
        // Simple: get all products (replace with paginate() if you prefer)
        $products = Product::orderBy('created_at', 'desc')->get();

        // Normalize images so blade logic stays consistent
        $products = $products->map(function($p) {
            $imgs = $p->images ?? [];

            if (is_string($imgs) && in_array(substr(trim($imgs), 0, 1), ['[','{'])) {
                $decoded = json_decode($imgs, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $imgs = $decoded;
                }
            }

            if ($imgs instanceof \Illuminate\Support\Collection) {
                $imgs = $imgs->toArray();
            }

            if (!is_array($imgs)) {
                $imgs = $imgs ? [(string)$imgs] : [];
            }

            $p->images = $imgs;
            return $p;
        });

        return view('frontend.product.index', compact('products'));
        // If your view path is lowercase 'frontend.product.index' adjust accordingly
    }
}
