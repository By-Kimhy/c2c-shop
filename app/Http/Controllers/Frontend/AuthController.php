<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|unique:users,email',
            'password' => ['required','confirmed', Password::min(8)],
            'is_buyer' => 'sometimes|boolean',
            'is_seller' => 'sometimes|boolean',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_buyer' => $request->has('is_buyer') ? (bool)$request->input('is_buyer') : true,
            'is_seller' => $request->has('is_seller') ? (bool)$request->input('is_seller') : true,
        ]);

        Auth::login($user);

        // redirect to seller dashboard if only seller, else to home or seller dashboard if both
        if ($user->isSeller() && ! $user->isBuyer()) {
            return redirect()->route('seller.dashboard')->with('success','Welcome, seller!');
        }

        return redirect()->route('home')->with('success','Registered successfully.');
    }

    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            // optional: redirect to intended or seller dashboard
            $user = Auth::user();
            if ($user->isSeller() && ! $user->isBuyer()) {
                return redirect()->intended(route('seller.dashboard'));
            }
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
