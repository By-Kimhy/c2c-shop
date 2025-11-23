<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Show cart page
    // public function index()
    // {
    //     $cart = session('cart', []);

    //     // Build collection of items with guaranteed keys
    //     $items = collect($cart)->map(function ($item, $key) {
    //         if (!isset($item['id'])) {
    //             $item['id'] = $key;
    //         }
    //         $item['price'] = isset($item['price']) ? (float)$item['price'] : 0.0;
    //         $item['qty']   = isset($item['qty']) ? (int)$item['qty'] : 0;
    //         $item['image'] = $item['image'] ?? null;
    //         $item['name']  = $item['name'] ?? 'No name';
    //         return $item;
    //     })->values();

    //     $subtotal = $items->reduce(function ($carry, $item) {
    //         return $carry + ($item['price'] * $item['qty']);
    //     }, 0);

    //     return view('frontend.cart.index', compact('items', 'subtotal'));
    // }

    public function index()
    {
        $cart = session('cart', []);

        // map into collection and guarantee keys + image string
        $items = collect($cart)->map(function ($item, $key) {
            // ensure id exists
            if (!isset($item['id'])) {
                $item['id'] = $key;
            }

            // coerce price and qty
            $item['price'] = isset($item['price']) ? (float) $item['price'] : 0.0;
            $item['qty'] = isset($item['qty']) ? (int) $item['qty'] : 0;
            $item['name'] = $item['name'] ?? 'No name';

            // If image is already a non-empty string/URL, keep it
            $img = $item['image'] ?? null;
            if (!empty($img) && (is_string($img) || preg_match('#^https?://#i', (string) $img))) {
                // if it's JSON/array stored as string, try to decode below
            } else {
                $img = null;
            }

            // If image is null -> try to load product and extract first image
            if (empty($img)) {
                try {
                    $product = \App\Models\Product::find($item['id']);
                    if ($product) {
                        $imgs = $product->images ?? [];

                        // if images stored as JSON string, decode
                        if (is_string($imgs) && in_array(substr(trim($imgs), 0, 1), ['[', '{'])) {
                            $decoded = json_decode($imgs, true);
                            if (json_last_error() === JSON_ERROR_NONE)
                                $imgs = $decoded;
                        }
                        // if collection -> to array
                        if ($imgs instanceof \Illuminate\Support\Collection)
                            $imgs = $imgs->toArray();

                        if (is_array($imgs) && count($imgs)) {
                            $img = $imgs[0] ?? null;
                        } elseif (is_string($imgs) && !empty($imgs)) {
                            $img = $imgs; // maybe a single path
                        }
                    }
                } catch (\Throwable $e) {
                    // ignore, fallback to null
                    $img = $img ?? null;
                }
            }

            $item['image'] = $img; // could be null or string

            return $item;
        })->values();

        // recalc subtotal
        $subtotal = $items->reduce(function ($carry, $item) {
            return $carry + ($item['price'] * $item['qty']);
        }, 0);

        return view('frontend.cart.index', compact('items', 'subtotal'));
    }


    // Add to cart (POST). Accepts product_id or id and qty.
    public function add(Request $request)
    {
        $id = $request->input('product_id') ?? $request->input('id');
        $qty = max(1, (int) ($request->input('qty') ?? 1));

        $product = Product::findOrFail($id);

        // Normalize product images to a simple array and choose first
        $imgs = $product->images ?? [];
        if (is_string($imgs)) {
            $decoded = json_decode($imgs, true);
            if (json_last_error() === JSON_ERROR_NONE)
                $imgs = $decoded;
        }
        if ($imgs instanceof \Illuminate\Support\Collection) {
            $imgs = $imgs->toArray();
        }
        if (!is_array($imgs)) {
            $imgs = (array) $imgs;
        }
        $firstImage = $imgs[0] ?? null;

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'qty' => $qty,
                'image' => $firstImage, // simple string or null
            ];
        }

        session()->put('cart', $cart);

        $cartCount = collect(session('cart', []))->sum('qty');

        if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'success' => true,
                'cart_count' => $cartCount,
            ]);
        }

        return redirect()->back()->with('success', 'បានបន្ថែមចូលកន្ត្រក!');
    }

    // Update quantities: expects items[<id>][qty]
    public function update(Request $request)
    {
        $inputItems = $request->input('items', []);
        $cart = session()->get('cart', []);

        foreach ($inputItems as $id => $data) {
            $qty = isset($data['qty']) ? (int) $data['qty'] : 0;
            if ($qty <= 0) {
                unset($cart[$id]);
            } else {
                if (isset($cart[$id])) {
                    $cart[$id]['qty'] = $qty;
                } else {
                    $product = Product::find($id);
                    if ($product) {
                        $imgs = $product->images ?? [];
                        if (is_string($imgs)) {
                            $decoded = json_decode($imgs, true);
                            if (json_last_error() === JSON_ERROR_NONE)
                                $imgs = $decoded;
                        }
                        if ($imgs instanceof \Illuminate\Support\Collection)
                            $imgs = $imgs->toArray();
                        $firstImage = is_array($imgs) ? ($imgs[0] ?? null) : null;

                        $cart[$id] = [
                            'id' => $id,
                            'name' => $product->name,
                            'price' => (float) $product->price,
                            'qty' => $qty,
                            'image' => $firstImage,
                        ];
                    }
                }
            }
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Cart updated.');
    }

    // Remove item (via product_id or id)
    public function remove(Request $request)
    {
        $id = $request->input('product_id') ?? $request->input('id');
        $cart = session()->get('cart', []);
        if ($id && isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Item removed.');
    }

    // Clear cart
    public function clear(Request $request)
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared.');
    }
}
