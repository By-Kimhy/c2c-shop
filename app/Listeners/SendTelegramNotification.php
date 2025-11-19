<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendTelegramNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId   = env('TELEGRAM_CHAT_ID');

        $order = $event->order;
        $text  = "🛒 New order received!\n"
               . "Order #: {$order->order_number}\n"
               . "Total: {$order->total} {$order->currency}";

        try {
            // Send Telegram message
            $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text'    => $text,
            ]);

            $status = $response->successful() ? 'sent' : 'failed';

            // Log notification in DB
            DB::table('telegram_notifications')->insert([
                'order_id'   => $order->id,
                'status'     => $status,
                'sent_at'    => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (! $response->successful()) {
                Log::warning('Telegram notification failed', [
                    'order_id' => $order->id,
                    'response' => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            // Catch network or API errors
            DB::table('telegram_notifications')->insert([
                'order_id'   => $order->id,
                'status'     => 'error',
                'sent_at'    => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::error('Telegram notification exception', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }
}