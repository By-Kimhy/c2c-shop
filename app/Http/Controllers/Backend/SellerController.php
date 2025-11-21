<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SellerController extends Controller
{
    /**
     * List users who have the seller role.
     */
    public function index(Request $request): View
    {
        // eager load roles
        $query = User::with('roles')
            ->whereHas('roles', function($q){ $q->where('name', 'seller'); })
            ->orderBy('created_at', 'desc');

        if ($q = $request->input('q')) {
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $sellers = $query->paginate(20)->withQueryString();

        return view('backend.sellers.index', compact('sellers'));
    }

    /**
     * Show seller details (re-uses user info).
     */
    public function show($id): View
    {
        $seller = User::with('roles')->findOrFail($id);

        // Ensure this user is a seller
        if (! $seller->hasRole('seller')) {
            abort(404, 'Seller not found.');
        }

        return view('backend.sellers.show', compact('seller'));
    }

    /**
     * Toggle approval status for seller.
     * We store approval state in users table in a simple column `is_approved` (0/1).
     * If you don't have this column, the method will add it data-wise — see notes.
     */
    public function toggleApprove(Request $request, $id)
    {
        $seller = User::findOrFail($id);

        if (! $seller->hasRole('seller')) {
            return response()->json(['message' => 'User is not a seller.'], 400);
        }

        $seller->is_approved = $seller->is_approved ? 0 : 1;
        $seller->save();

        return response()->json([
            'message' => $seller->is_approved ? 'Seller approved.' : 'Seller suspended.',
            'is_approved' => (int) $seller->is_approved
        ]);
    }

    /**
     * Delete seller (delegates to the User delete logic).
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (! $user->hasRole('seller')) {
            return redirect()->route('admin.sellers.index')->with('error', 'User is not a seller.');
        }

        // reuse your UserController deletion logic: detach roles + delete
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.sellers.index')->with('success', 'Seller deleted.');
    }
}
