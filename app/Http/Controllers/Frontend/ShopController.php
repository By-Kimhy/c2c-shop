<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SellerProfile;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function show($slug)
    {
        $profile = \App\Models\SellerProfile::where('slug', $slug)->with('user')->firstOrFail();

        // optional search query
        $q = request('q');

        $productsQuery = \App\Models\Product::where('user_id', $profile->user_id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc');

        if ($q) {
            $productsQuery->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $products = $productsQuery->paginate(12);

        return view('frontend.shop.show', compact('profile', 'products', 'q'));
    }

}
