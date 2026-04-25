<?php

namespace App\Services;

use App\Models\ProblemLog;
use App\Models\ResolutionTemplate;
use Illuminate\Support\Str;

class ResolutionTemplateDedupService
{
    public function findBestMatch(ProblemLog $problemLog, string $resolutionText): ?ResolutionTemplate
    {
        $needle = $this->normalize(
            trim(($problemLog->title ?? '') . ' ' . ($problemLog->description ?? '') . ' ' . $resolutionText)
        );

        if ($needle === '') {
            return null;
        }

        $templates = ResolutionTemplate::query()
            ->where('is_active', true)
            ->get();

        $best = null;
        $bestScore = 0;

        foreach ($templates as $template) {
            $hay = $this->normalize(
                trim(($template->title ?? '') . ' ' . ($template->resolution_steps ?? '') . ' ' . ($template->notes ?? ''))
            );

            if ($hay === '') {
                continue;
            }

            similar_text($needle, $hay, $percent);

            if ($percent > $bestScore) {
                $bestScore = $percent;
                $best = $template;
            }
        }

        return $bestScore >= 82 ? $best : null;
    }

    private function normalize(string $text): string
    {
        $text = Str::lower($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }
}
