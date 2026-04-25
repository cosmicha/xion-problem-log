<?php

namespace App\Console\Commands;

use App\Services\TelegramLinkService;
use Illuminate\Console\Command;

class SyncTelegramLinks extends Command
{
    protected $signature = 'telegram:sync-links';
    protected $description = 'Sync Telegram link codes from bot updates';

    public function handle(TelegramLinkService $telegram): int
    {
        $count = $telegram->syncUpdates();
        $this->info("Telegram links synced: {$count}");
        return self::SUCCESS;
    }
}
