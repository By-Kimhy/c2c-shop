<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Allow only authenticated users that have the 'admin' role.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // Use your User->hasRole('admin') or adjust as needed
        if (! method_exists($user, 'hasRole') || ! $user->hasRole('admin')) {
            Auth::logout();
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Unauthorized (admin only).']);
        }

        return $next($request);
    }
}
