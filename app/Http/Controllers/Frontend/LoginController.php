<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ]);

        $credentials = ['email' => $data['email'], 'password' => $data['password']];

        // Attempt login
        if (Auth::attempt($credentials, (bool) ($data['remember'] ?? false))) {
            $user = Auth::user();

            // Prevent admin accounts logging in via frontend
            if ($user->isAdmin()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Admin accounts must login from the admin area.'])->withInput();
            }

            // If email not verified -> redirect to notice
            if (method_exists($user, 'hasVerifiedEmail') && !$user->hasVerifiedEmail()) {
                Auth::logout(); // optional: require verification before using site
                // If you prefer to allow login but force verification, remove logout()
                return redirect()->route('verification.notice')
                    ->with('info', 'Please verify your email before continuing. A verification link was sent to your email.');
            }

            // success
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
