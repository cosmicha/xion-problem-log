<?php

namespace App\Console\Commands;

use App\Models\ProblemLog;
use App\Models\ResolutionTemplate;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportClosedTicketsToKnowledgeBase extends Command
{
    protected $signature = 'kb:import-closed-tickets {--limit=0} {--dry-run}';
    protected $description = 'Import closed tickets with close notes into knowledge base templates';

    public function handle(): int
    {
        $limit = (int) $this->option('limit');
        $dryRun = (bool) $this->option('dry-run');

        $query = ProblemLog::query()
            ->where('status', 'closed')
            ->whereNotNull('close_note')
            ->whereRaw("trim(close_note) != ''")
            ->orderBy('closed_at');

        if ($limit > 0) {
            $query->limit($limit);
        }

        $logs = $query->get();

        if ($logs->isEmpty()) {
            $this->info('No closed tickets with close note found.');
            return self::SUCCESS;
        }

        $created = 0;
        $skipped = 0;

        foreach ($logs as $log) {
            $title = trim((string) $log->title);
            $description = trim((string) $log->description);
            $closeNote = trim((string) $log->close_note);

            if ($title === '' || $closeNote === '') {
                $skipped++;
                continue;
            }

            $symptoms = trim(collect([$title, $description])
                ->filter(fn ($v) => trim((string) $v) !== '')
                ->implode(', '));

            $existing = ResolutionTemplate::query()
                ->where(function ($q) use ($title, $closeNote) {
                    $q->where('title', $title)
                      ->orWhere('resolution_steps', $closeNote);
                })
                ->first();

            if ($existing) {
                $this->line("SKIP ticket #{$log->id} -> already matched KB #{$existing->id}");
                $skipped++;
                continue;
            }

            $payload = [
                'title' => $title,
                'category' => $this->inferCategory($title . ' ' . $description . ' ' . $closeNote),
                'symptom_keywords' => $symptoms,
                'resolution_steps' => $closeNote,
                'notes' => 'Imported from closed ticket #' . $log->id . ' (' . ($log->ticket_number ?? 'N/A') . ')',
                'usage_count' => 1,
                'success_count' => 1,
                'learning_score' => 4,
                'is_active' => true,
                'ai_processed' => false,
                'last_used_at' => $log->closed_at,
                'is_primary' => true,
            ];

            if ($dryRun) {
                $this->info("DRY RUN create KB from ticket #{$log->id}: {$title}");
                continue;
            }

            $template = ResolutionTemplate::create($payload);

            try {
                app(\App\Services\OpenAiResolutionTemplateRefinerService::class)->process($template);
            } catch (\Throwable $e) {
                $this->warn("AI refine failed for KB #{$template->id}: " . $e->getMessage());
            }

            try {
                app(\App\Services\ResolutionTemplateGroupingService::class)->regroupAll();
            } catch (\Throwable $e) {
                $this->warn("Grouping failed after KB #{$template->id}: " . $e->getMessage());
            }

            $this->info("CREATED KB #{$template->id} from ticket #{$log->id}: {$title}");
            $created++;
        }

        $this->newLine();
        $this->info("Done. Created: {$created}, Skipped: {$skipped}");

        return self::SUCCESS;
    }

    private function inferCategory(string $text): string
    {
        $text = Str::lower($text);

        if (Str::contains($text, ['monitor', 'screen', 'display', 'tv', 'videotron'])) {
            return 'Display';
        }

        if (Str::contains($text, ['power', 'listrik', 'saklar', 'adaptor', 'mati total'])) {
            return 'Electrical';
        }

        if (Str::contains($text, ['network', 'internet', 'wifi', 'lan'])) {
            return 'Network';
        }

        if (Str::contains($text, ['cms', 'software', 'system', 'login'])) {
            return 'Software';
        }

        return 'Hardware';
    }
}
