<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebugKhqrController extends Controller
{
    public function show(Request $request)
    {
        return response("DebugKhqrController hit OK\n", 200)
            ->header('Content-Type', 'text/plain');
    }
}
