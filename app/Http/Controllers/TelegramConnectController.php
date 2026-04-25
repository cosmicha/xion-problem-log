<?php

namespace App\Http\Controllers;

use App\Services\TelegramAlertService;
use App\Services\TelegramLinkService;
use Illuminate\Http\Request;

class TelegramConnectController extends Controller
{
    public function show(Request $request, TelegramLinkService $telegram)
    {
        $user = $request->user();
        $code = $telegram->ensureCode($user);
        $botUsername = $telegram->botUsername();

        return view('telegram.connect', compact('user', 'code', 'botUsername'));
    }

    public function sync(Request $request, TelegramLinkService $telegram)
    {
        $telegram->syncUpdates();

        return back()->with('success', 'Telegram sync completed. If you already sent the code to the bot, your Chat ID should be connected now.');
    }

    public function test(Request $request, TelegramAlertService $alerts)
    {
        $user = $request->user();

        if (!$user->telegram_chat_id) {
            return back()->with('error', 'Telegram is not connected yet.');
        }

        $alerts->send([$user->telegram_chat_id], 'Test Telegram alert from Xion1 Support System ✅');

        return back()->with('success', 'Test Telegram message sent.');
    }
}
