<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SellerProfile;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function show($slug)
    {
        $profile = SellerProfile::with(['user','user.products'])->where('slug', $slug)->firstOrFail();

        // if you want only approved shops visible:
        if ($profile->status !== 'approved') {
            abort(404);
        }

        // You can eager load products with pagination or simple list
        $products = $profile->user->products()->where('status','published')->paginate(12);

        return view('frontend.shop.show', compact('profile','products'));
    }
}
