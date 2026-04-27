<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramAlertService
{
    private static array $sentFingerprints = [];

    public function send(array $chatIds, string $message, array $buttons = []): void
    {
        $botToken = config('services.telegram.bot_token');

        if (empty($botToken) || empty($chatIds)) return;

        $chatIds = array_values(array_unique(array_filter(array_map(
            fn ($id) => trim((string) $id),
            $chatIds
        ))));

        foreach ($chatIds as $chatId) {
            if ($chatId === '') continue;

            $fingerprint = sha1($chatId . '|' . trim($message) . '|' . json_encode($buttons));

            if (isset(self::$sentFingerprints[$fingerprint])) continue;

            self::$sentFingerprints[$fingerprint] = true;

            $payload = [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];

            if ($buttons) {
                $payload['reply_markup'] = json_encode([
                    'inline_keyboard' => $buttons,
                ]);
            }

            try {
                Http::timeout(10)->post("https://api.telegram.org/bot{$botToken}/sendMessage", $payload);
            } catch (\Throwable $e) {
                Log::error('Telegram alert failed', [
                    'chat_id' => $chatId,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    public function answerCallback(string $callbackId, string $text): void
    {
        $botToken = config('services.telegram.bot_token');

        if (!$botToken || !$callbackId) return;

        try {
            Http::timeout(10)->post("https://api.telegram.org/bot{$botToken}/answerCallbackQuery", [
                'callback_query_id' => $callbackId,
                'text' => $text,
                'show_alert' => false,
            ]);
        } catch (\Throwable $e) {
            Log::error('Telegram callback answer failed', ['error' => $e->getMessage()]);
        }
    }
}
