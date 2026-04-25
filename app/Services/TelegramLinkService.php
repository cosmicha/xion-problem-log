<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TelegramLinkService
{
    public function ensureCode(User $user): string
    {
        if (!$user->telegram_link_code) {
            $user->telegram_link_code = Str::upper(Str::random(10));
            $user->save();
        }

        return $user->telegram_link_code;
    }

    public function botUsername(): ?string
    {
        $token = config('services.telegram.bot_token');

        if (!$token) {
            return null;
        }

        try {
            $res = Http::timeout(10)->get("https://api.telegram.org/bot{$token}/getMe")->json();
            return $res['result']['username'] ?? null;
        } catch (\Throwable $e) {
            Log::error('Telegram getMe failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function syncUpdates(): int
    {
        $token = config('services.telegram.bot_token');

        if (!$token) {
            return 0;
        }

        try {
            $data = Http::timeout(15)->get("https://api.telegram.org/bot{$token}/getUpdates")->json();
        } catch (\Throwable $e) {
            Log::error('Telegram getUpdates failed', ['error' => $e->getMessage()]);
            return 0;
        }

        $linked = 0;

        foreach (($data['result'] ?? []) as $update) {
            $message = $update['message'] ?? null;
            if (!$message) continue;

            $text = trim((string)($message['text'] ?? ''));
            $chatId = (string)($message['chat']['id'] ?? '');

            if (!$text || !$chatId) continue;

            if (preg_match('/(?:\/start|connect|link)\s+([A-Z0-9]{6,20})/i', $text, $m)) {
                $code = strtoupper($m[1]);

                $user = User::where('telegram_link_code', $code)->first();

                if ($user) {
                    $user->telegram_chat_id = $chatId;
                    $user->telegram_linked_at = now();
                    $user->save();
                    $linked++;
                }
            }
        }

        return $linked;
    }
}
