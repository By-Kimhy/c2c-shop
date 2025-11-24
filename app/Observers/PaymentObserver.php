<?php
namespace App\Observers;

use App\Models\Payment;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;

class PaymentObserver
{
    protected TelegramService $tg;

    public function __construct()
    {
        $this->tg = new TelegramService();
    }

    public function updated(Payment $payment)
    {
        // if status changed and now equals the PAID constant
        if ($payment->isDirty('status') && strtolower($payment->status) === Payment::STATUS_PAID) {
            $this->notifyTelegram($payment);
        }
    }

    protected function notifyTelegram(Payment $p): void
    {
        try {
            $order = $p->order;
            $orderNumber = $order->order_number ?? ($order->id ?? 'N/A');
            $amount = number_format($p->amount ?? ($order->total ?? 0), 2);
            $providerRef = $p->provider_ref ?? '-';
            $payer = $order->shipping_name ?? $order->name ?? $order->email ?? '-';

            // Compose message using Markdown (escape backticks etc if needed)
            $text = "*Payment received*\n";
            $text .= "Order: `{$orderNumber}`\n";
            $text .= "Amount: {$amount} {$p->currency}\n";
            $text .= "Provider: {$p->provider}\n";
            $text .= "Ref: `{$providerRef}`\n";
            $text .= "Payer: {$payer}\n";

            // Admin link (if you have backend route)
            if ($order && isset($order->id)) {
                $adminUrl = url("/backend/orders/{$order->id}");
                $text .= "\n[View order]({$adminUrl})";
            }

            $this->tg->sendMessage($text, [
                'parse_mode' => 'Markdown',
                'disable_web_page_preview' => true,
            ]);
        } catch (\Throwable $e) {
            Log::error('PaymentObserver notifyTelegram failed: ' . $e->getMessage());
        }
    }
}
