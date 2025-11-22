<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\SellerProfile;

class SellerAccountController extends Controller
{
    protected function ensureSellerProfile($user)
    {
        if (! $user->sellerProfile) {
            // create an empty pending profile if none exists
            $slug = Str::slug($user->name ?: 'shop') . '-' . Str::random(4);
            $user->sellerProfile()->create([
                'shop_name' => $user->name . "'s shop",
                'slug' => $slug,
                'status' => 'pending',
            ]);
            $user->refresh(); // reload relations
        }
        return $user->sellerProfile;
    }

    public function dashboard(Request $r)
    {
        $user = $r->user();
        $profile = $user->sellerProfile ?? $user->sellerProfile()->create([
            'shop_name' => $user->name . "'s shop",
            'slug' => \Illuminate\Support\Str::slug($user->name).'-'.\Illuminate\Support\Str::random(4),
            'status' => 'pending'
        ]);
        return view('frontend.seller.dashboard', compact('profile'));
    }


    public function edit(Request $request)
    {
        $user = $request->user();
        $profile = $this->ensureSellerProfile($user);
        return view('frontend.seller.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $profile = $this->ensureSellerProfile($user);

        $data = $request->validate([
            'shop_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('logo')) {
            if ($profile->logo) Storage::disk('public')->delete($profile->logo);
            $data['logo'] = $request->file('logo')->store('seller_logos', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($profile->banner) Storage::disk('public')->delete($profile->banner);
            $data['banner'] = $request->file('banner')->store('seller_banners', 'public');
        }

        // update slug if shop_name changed
        if ($profile->shop_name !== $data['shop_name']) {
            $data['slug'] = Str::slug($data['shop_name']) . '-' . Str::random(4);
        }

        $profile->update($data);

        // When seller edits, set status to pending for admin review (optional)
        $profile->status = 'pending';
        $profile->save();

        return redirect()->route('seller.dashboard')->with('success', 'Profile updated and sent for review.');
    }
}
