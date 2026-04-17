<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RegroupKnowledgeBase extends Command
{
    protected $signature = 'kb:regroup {--dry-run}';
    protected $description = 'Regroup similar knowledge base entries into a primary procedure with alternatives';

    public function handle(): int
    {
        if ($this->option('dry-run')) {
            $this->info('Dry run OK. Grouping service is available.');
            return self::SUCCESS;
        }

        try {
            app(\App\Services\ResolutionTemplateGroupingService::class)->regroupAll();
            $this->info('Knowledge base regroup completed successfully.');
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Knowledge base regroup failed: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
