<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductDetailController extends Controller
{
    public function index(Request $request)
    {
        // accept ?id= or change to route param later
        $id = $request->query('id');
        if (! $id) {
            abort(404, 'Product id missing');
        }

        $product = Product::with(['user','category'])->findOrFail($id);

        // Ensure image paths are relative to storage/app/public
        $images = $product->images ?: [];
        $normalized = [];
        foreach ($images as $img) {
            $img = ltrim($img, '/');
            $img = str_replace('private/public/', '', $img);
            $img = str_replace('private/', '', $img);
            $img = str_replace('public/', '', $img);
            $img = str_replace('storage/', '', $img);
            $normalized[] = $img;
        }
        // pass normalized images to view
        $product->images = $normalized;

        return view('frontend.product.product-detail', compact('product'));
    }

    public function show($id)
    {
        // load product (with optional relations)
        $product = Product::with(['category', 'user', /* add relations if needed */])->find($id);

        if (! $product) {
            abort(404, 'Product not found.');
        }

        // Normalize images to a simple PHP array for view usage (handles JSON, collection, string)
        $imgs = $product->images ?? [];
        if (is_string($imgs) && in_array(substr(trim($imgs), 0, 1), ['[', '{'])) {
            $decoded = json_decode($imgs, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $imgs = $decoded;
            }
        }
        if ($imgs instanceof \Illuminate\Support\Collection) {
            $imgs = $imgs->toArray();
        }
        if (!is_array($imgs)) {
            // If it's a single string path, convert to array for consistency
            $imgs = $imgs ? [(string)$imgs] : [];
        }

        // attach normalized images back to product for view convenience
        $product->images = $imgs;

        return view('frontend.product.product-detail', compact('product'));
        // If your view file path differs, adjust the view string (e.g. 'frontend.productDetail')
    }
}
