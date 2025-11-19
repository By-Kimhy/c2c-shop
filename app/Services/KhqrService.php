<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KhqrService
{
    // Build payload from order model
    public function makePayload(Order $order): array
    {
        return [
            'merchant_id' => env('KHQR_MERCHANT_ID'),
            'merchant_name' => env('KHQR_MERCHANT_NAME'),
            'amount' => (float) $order->total,
            'currency' => $order->currency,
            'reference' => $order->order_number,
        ];
    }

    // Minimal QR: returns data:image/svg+xml;base64,SVG
    public function qrSvgDataUri(array $payload): string
    {
        $text = htmlspecialchars(json_encode($payload), ENT_QUOTES, 'UTF-8');
        $svg = "<svg xmlns='http://www.w3.org/2000/svg' width='280' height='280'><rect width='100%' height='100%' fill='#fff'/><text x='10' y='20' font-size='10'>KHQR</text><text x='10' y='40' font-size='10'>{$text}</text></svg>";
        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }

    // Verify callback token (simple protection)
    public function validateCallback(Request $request): bool
    {
        return $request->header('X-KHQR-TOKEN') === env('KHQR_CALLBACK_TOKEN') || $request->input('token') === env('KHQR_CALLBACK_TOKEN');
    }
}
