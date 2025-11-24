<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // show login form
    public function showLoginForm()
    {
        return view('backend.auth.login'); // path you already have
    }

    // process login
    // public function login(Request $request)
    // {
    //     $data = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //         'remember' => 'sometimes|boolean'
    //     ]);

    //     $user = User::where('email', $data['email'])->first();

    //     if (! $user) {
    //         return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    //     }

    //     // IMPORTANT: check hashed password
    //     if (! Hash::check($data['password'], $user->password)) {
    //         return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    //     }

    //     // confirm user has admin role
    //     if (! method_exists($user, 'hasRole') || ! $user->hasRole('admin')) {
    //         return back()->withErrors(['email' => 'Unauthorized (admin only)'])->withInput();
    //     }

    //     // login
    //     $remember = $request->has('remember');
    //     Auth::login($user, $remember);

    //     return redirect()->intended(route('admin.dashboard'));
    // }

    // public function login(Request $request)
    // {
    //     $data = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //         'remember' => 'sometimes|boolean'
    //     ]);

    //     $user = User::where('email', $data['email'])->first();

    //     if (!$user) {
    //         return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    //     }

    //     if (!\Illuminate\Support\Facades\Hash::check($data['password'], $user->password)) {
    //         return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    //     }

    //     // Use your is_admin flag (you set it earlier). If you prefer roles, change this.
    //     if (!($user->is_admin ?? false)) {
    //         return back()->withErrors(['email' => 'Unauthorized (admin only)'])->withInput();
    //     }

    //     $remember = $request->has('remember');
    //     \Illuminate\Support\Facades\Auth::login($user, $remember);

    //     return redirect()->intended(route('admin.dashboard'));
    // }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        // require admin role
        if (!($user->is_admin ?? false)) {
            return back()->withErrors(['email' => 'Unauthorized (admin only)'])->withInput();
        }

        Auth::login($user, $request->filled('remember'));

        return redirect()->intended(route('admin.dashboard'));
    }


    // logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
