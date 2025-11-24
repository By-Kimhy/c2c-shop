<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $botToken;
    protected string|int $chatId;
    protected string $apiBase;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token') ?: env('TELEGRAM_BOT_TOKEN');
        $this->chatId = config('services.telegram.chat_id') ?: env('TELEGRAM_CHAT_ID');
        $this->apiBase = "https://api.telegram.org/bot{$this->botToken}";
    }

    public function sendMessage(string $text, array $opts = []): ?array
    {
        if (empty($this->botToken) || empty($this->chatId)) {
            Log::warning('TelegramService: missing bot token or chat id');
            return null;
        }

        $payload = array_merge([
            'chat_id' => $this->chatId,
            'text'    => $text,
        ], $opts);

        try {
            $resp = Http::post($this->apiBase . '/sendMessage', $payload);
            if ($resp->ok()) {
                return $resp->json();
            }
            Log::error('TelegramService: sendMessage failed', [
                'status' => $resp->status(),
                'body'   => $resp->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error('TelegramService exception: ' . $e->getMessage());
        }

        return null;
    }
}
