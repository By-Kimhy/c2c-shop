<?php

// app/Http/Kernel.php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'ensure.seller' => \App\Http\Middleware\EnsureSeller::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        // optional alias
        'is_admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
