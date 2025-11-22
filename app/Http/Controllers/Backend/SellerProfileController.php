<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SellerProfile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProfileController extends Controller
{
    /**
     * List seller profiles
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $status = $request->status;

        // Get seller role
        $sellerRole = Role::where('name', 'seller')->first();
        $sellerIds = $sellerRole
            ? DB::table('role_user')->where('role_id', $sellerRole->id)->pluck('user_id')->toArray()
            : [];

        // Query seller profiles
        $query = SellerProfile::with('user')
            ->whereIn('user_id', $sellerIds);

        // Search
        if ($q) {
            $query->where(function ($s) use ($q) {
                $s->where('shop_name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%");
            });
        }

        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }

        $profiles = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('backend.sellers.profiles.index', compact('profiles', 'q', 'status'));
    }

    /**
     * Edit seller profile
     */
    public function edit($id)
    {
        $profile = SellerProfile::with('user')->findOrFail($id);
        $allUsers = \App\Models\User::orderBy('name')->get();
        return view('backend.sellers.profiles.edit', compact('profile', 'allUsers'));
    }


    public function fixMissing()
    {
        $role = \App\Models\Role::where('name', 'seller')->first();

        if (!$role) {
            return back()->with('error', 'Seller role not found.');
        }

        $userIds = \DB::table('role_user')->where('role_id', $role->id)->pluck('user_id')->toArray();
        $created = 0;

        foreach ($userIds as $uid) {
            $user = \App\Models\User::find($uid);

            if (!$user) {
                continue;
            }

            if ($user->sellerProfile) {
                continue; // already has profile
            }

            $slug = \Illuminate\Support\Str::slug($user->name . '-shop-' . \Illuminate\Support\Str::random(4));

            \App\Models\SellerProfile::create([
                'user_id' => $user->id,
                'shop_name' => $user->name . ' Shop',
                'slug' => $slug,
                'description' => 'Auto-created seller profile',
                'status' => 'pending'
            ]);

            $created++;
        }

        return back()->with('success', "Fix completed. Created {$created} missing profiles.");
    }


    /**
     * Update seller profile
     */
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

        // Upload logo
        if ($request->hasFile('logo')) {
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }
            $data['logo'] = $request->file('logo')->store('seller_logos', 'public');
        }

        // Upload banner
        if ($request->hasFile('banner')) {
            if ($profile->banner) {
                Storage::disk('public')->delete($profile->banner);
            }
            $data['banner'] = $request->file('banner')->store('seller_banners', 'public');
        }

        // Update slug if shop_name changed
        if ($profile->shop_name !== $data['shop_name']) {
            $data['slug'] = Str::slug($data['shop_name']) . '-' . Str::random(4);
        }

        $profile->update($data);

        // Handle verified_at + user flag
        if ($profile->status === 'approved') {
            $profile->verified_at = $profile->verified_at ?? now();
            $profile->save();

            $profile->user->is_approved = 1;
            $profile->user->save();
        } else {
            $profile->user->is_approved = 0;
            $profile->user->save();
        }

        return redirect()
            ->route('admin.seller-profiles.index')
            ->with('success', 'Seller profile updated.');
    }

    /**
     * Delete profile
     */
    public function destroy($id)
    {
        $profile = SellerProfile::findOrFail($id);

        if ($profile->logo) {
            Storage::disk('public')->delete($profile->logo);
        }

        if ($profile->banner) {
            Storage::disk('public')->delete($profile->banner);
        }

        $profile->delete();

        return redirect()
            ->route('admin.seller-profiles.index')
            ->with('success', 'Seller profile deleted.');
    }

    public function linkUser(Request $request, $id)
    {
        $profile = SellerProfile::findOrFail($id);

        $data = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = \App\Models\User::findOrFail($data['user_id']);

        // Prevent assigning user who already has a seller profile
        if ($user->sellerProfile && $user->sellerProfile->id != $profile->id) {
            return back()->with('error', 'This user already has a seller profile.');
        }

        // Attach seller role if missing
        $sellerRole = \App\Models\Role::where('name', 'seller')->first();
        if ($sellerRole && !$user->roles()->where('role_id', $sellerRole->id)->exists()) {
            $user->roles()->attach($sellerRole->id);
        }

        // Link the user
        $profile->user_id = $user->id;
        $profile->save();

        return back()->with('success', 'User successfully linked to this seller profile.');
    }

}
