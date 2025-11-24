<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Log::debug('[DEBUG AdminMiddleware] start', [
            'uri' => $request->getRequestUri(),
            'guard_web' => Auth::guard('web')->check(),
            'user' => optional(Auth::guard('web')->user())->only(['id','email','is_admin']),
        ]);

        if (! Auth::guard('web')->check()) {
            Log::debug('[DEBUG AdminMiddleware] not authenticated - redirect to admin.login');
            return redirect()->route('admin.login');
        }

        $user = Auth::guard('web')->user();

        if (! ($user->is_admin ?? false)) {
            Log::debug('[DEBUG AdminMiddleware] not admin - abort/redirect', ['user_id' => $user->id ?? null]);
            return redirect('/')->with('error', 'Admin access required.');
        }

        Log::debug('[DEBUG AdminMiddleware] allowed - continuing', ['user_id' => $user->id]);
        return $next($request);
    }
}
