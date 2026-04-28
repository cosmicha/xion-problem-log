<?php

namespace App\Http\Controllers;

use App\Services\TelegramAlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TelegramConnectController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (empty($user->telegram_link_code)) {
            $user->telegram_link_code = strtoupper(Str::random(10));
            $user->save();
        }

        return view('telegram.connect', [
            'user' => $user,
            'code' => $user->telegram_link_code,
            'botUsername' => config('services.telegram.bot_username', 'your_bot'),
        ]);
    }

    public function sync(Request $request)
    {
        $user = Auth::user();

        if (!empty($user->telegram_chat_id)) {
            return back()->with('success', 'Telegram already connected.');
        }

        return back()->with('info', 'If /start does not connect automatically, send /myid to the bot, copy the Chat ID, then paste it manually here.');
    }

    public function manual(Request $request)
    {
        $request->validate([
            'telegram_chat_id' => ['required', 'string', 'max:50'],
        ]);

        $chatId = trim($request->telegram_chat_id);

        if (!preg_match('/^-?\d+$/', $chatId)) {
            return back()->with('error', 'Invalid Chat ID. Chat ID must be numeric, for example: 8263093704 or -100xxxxxxxxxx.');
        }

        $user = Auth::user();
        $user->telegram_chat_id = $chatId;
        $user->telegram_linked_at = now();
        $user->save();

        return back()->with('success', 'Telegram Chat ID saved successfully.');
    }

    public function test(TelegramAlertService $telegram)
    {
        $user = Auth::user();

        if (empty($user->telegram_chat_id)) {
            return back()->with('error', 'Telegram is not connected yet. Please save your Chat ID first.');
        }

        $telegram->send([$user->telegram_chat_id], "Telegram test message ✅\n\nYour support account is connected.");

        return back()->with('success', 'Test message sent. Please check Telegram.');
    }

    public function disconnect()
    {
        $user = Auth::user();
        $user->telegram_chat_id = null;
        $user->telegram_linked_at = null;
        $user->save();

        return back()->with('success', 'Telegram disconnected.');
    }
}
