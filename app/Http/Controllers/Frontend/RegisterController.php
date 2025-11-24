<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        return view('frontend.auth.register');
    }

    /**
     * Handle registration and send verification email.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                // default: both buyer and seller enabled (per your spec)
                'is_buyer' => 1,
                'is_seller' => 1,
                'is_admin' => 0,
            ]);

            // auto-create seller profile if you have seller_profiles table/model
            try {
                if (class_exists(\App\Models\SellerProfile::class)) {
                    \App\Models\SellerProfile::create([
                        'user_id' => $user->id,
                        'shop_name' => $user->name . "'s shop",
                        // add any other defaults your table requires (or remove keys)
                    ]);
                }
            } catch (\Throwable $e) {
                // don't fail registration if seller profile creation fails
                \Log::warning('Could not create seller profile automatically: ' . $e->getMessage());
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Registration failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Registration failed. Try again.'])->withInput();
        }

        // Fire Registered event & send email verification
        event(new Registered($user));
        // login the user (common pattern), then send verification
        Auth::login($user);
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')->with('success', 'Account created — please verify your email.');
    }
}
