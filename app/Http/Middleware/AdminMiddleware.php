<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class AdminMiddleware
// {
//     public function handle(Request $request, Closure $next)
//     {
//         Log::debug('[DEBUG AdminMiddleware] start', [
//             'uri' => $request->getRequestUri(),
//             'guard_web' => Auth::guard('web')->check(),
//             'user' => optional(Auth::guard('web')->user())->only(['id','email','is_admin']),
//         ]);

//         if (! Auth::guard('web')->check()) {
//             Log::debug('[DEBUG AdminMiddleware] not authenticated - redirect to admin.login');
//             return redirect()->route('admin.login');
//         }

//         $user = Auth::guard('web')->user();

//         if (! ($user->is_admin ?? false)) {
//             Log::debug('[DEBUG AdminMiddleware] not admin - abort/redirect', ['user_id' => $user->id ?? null]);
//             return redirect('/')->with('error', 'Admin access required.');
//         }

//         Log::debug('[DEBUG AdminMiddleware] allowed - continuing', ['user_id' => $user->id]);
//         return $next($request);
//     }
// }


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * - If user is not logged in -> redirect to admin login.
     * - If logged in but not admin -> abort 403 or redirect.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Guest -> redirect to admin login (important: we handle guest here so `auth` does not redirect to frontend /login)
        if (! $user) {
            // if request expects json return 401
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('admin.login');
        }

        // Not an admin
        if (! ($user->is_admin ?? false)) {
            // Option 1: abort
            abort(403, 'Access denied.');

            // Option 2: redirect to frontend home with message:
            // return redirect('/')->with('error','Admin access required.');
        }

        return $next($request);
    }
}

