<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProfileController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $query = SellerProfile::with('user')->orderBy('created_at', 'desc');

        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('shop_name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%")
                    ->orWhereHas('user', function($u) use ($q) {
                        $u->where('name','like',"%{$q}%")
                          ->orWhere('email','like',"%{$q}%");
                    });
            });
        }

        $profiles = $query->paginate(20)->withQueryString();
        return view('backend.sellers.profiles.index', compact('profiles','q'));
    }

    public function edit($id)
    {
        $profile = SellerProfile::with('user')->findOrFail($id);
        return view('backend.sellers.profiles.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $profile = SellerProfile::findOrFail($id);

        $data = $request->validate([
            'shop_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,approved,suspended',
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

        // set verified_at if approved
        if ($profile->status === 'approved') {
            $profile->verified_at = $profile->verified_at ?? now();
            $profile->save();
            // also mark user approved flag
            $profile->user->is_approved = 1;
            $profile->user->save();
        } else {
            $profile->user->is_approved = 0;
            $profile->user->save();
        }

        return redirect()->route('admin.seller-profiles.index')->with('success','Seller profile updated.');
    }

    public function destroy($id)
    {
        $profile = SellerProfile::findOrFail($id);
        // delete files
        if ($profile->logo) Storage::disk('public')->delete($profile->logo);
        if ($profile->banner) Storage::disk('public')->delete($profile->banner);

        // detach seller role if you want or keep user as buyer
        $user = $profile->user;
        $profile->delete();

        return redirect()->route('admin.seller-profiles.index')->with('success','Seller profile deleted.');
    }
}
