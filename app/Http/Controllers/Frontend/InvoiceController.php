<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function showStaticInvoice()
    {
        return view('frontend.invoice');
    }
}
