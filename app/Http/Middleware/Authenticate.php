<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Log to help debug why it returns frontend/admin
        Log::debug('[AUTH_REDIRECT] path=' . $request->path());

        if ($request->is('admin') || $request->is('admin/*')) {
            Log::debug('[AUTH_REDIRECT] returning admin.login');
            return route('admin.login');
        }

        Log::debug('[AUTH_REDIRECT] returning frontend login');
        return route('login');
    }
}
