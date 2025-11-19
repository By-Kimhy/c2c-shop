<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\View;

class InvoiceService
{
    /**
     * Render HTML for an order using a Blade view.
     */
    public function renderHtml(Order $order): string
    {
        return view('frontend.invoices.default', compact('order'))->render();
    }

    /**
     * Save the rendered invoice HTML into the order record.
     */
    public function saveHtml(Order $order): void
    {
        $order->invoice_html = $this->renderHtml($order);
        $order->save();
    }

    /**
     * Optionally export invoice as PDF (requires barryvdh/laravel-dompdf or similar).
     */
    public function renderPdf(Order $order): string
    {
        $html = $this->renderHtml($order);

        // Example if you install barryvdh/laravel-dompdf
        // return \PDF::loadHTML($html)->output();

        return $html; // fallback: just return HTML
    }
}