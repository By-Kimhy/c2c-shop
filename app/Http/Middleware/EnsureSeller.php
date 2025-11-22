<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSeller
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user || ! method_exists($user, 'isSeller') || ! $user->isSeller()) {
            // redirect to frontend or show 403
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Forbidden. Seller access only.'], 403);
            }
            return redirect('/')->with('error', 'You must be a seller to access that page.');
        }
        return $next($request);
    }
}
