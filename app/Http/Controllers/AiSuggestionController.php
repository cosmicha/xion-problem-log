<?php

namespace App\Http\Controllers;

use App\Models\ResolutionTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AiSuggestionController extends Controller
{
    public function suggest(Request $request)
    {
        $title = trim((string) $request->input('title'));
        $description = trim((string) $request->input('description'));

        $title = preg_replace('/^(title\s*:)?\s*/i', '', $title);
        $description = preg_replace('/^(description\s*:)?\s*/i', '', $description);

        $inputText = trim($title . ' ' . $description);

        if ($inputText === '' || strlen($inputText) < 3) {
            

        // === Knowledge Base Matching ===
        $kbMatches = \App\Models\ResolutionTemplate::query()
            ->where('is_active', true)
            ->get()
            ->map(function ($item) use ($normalized) {
                $text = strtolower(
                    ($item->ai_title ?? '') . ' ' .
                    ($item->ai_summary ?? '') . ' ' .
                    ($item->symptom_keywords ?? '')
                );

                similar_text($normalized, $text, $percent);

                return [
                    'id' => $item->id,
                    'title' => $item->displayTitle(),
                    'summary' => $item->displaySummary(),
                    'score' => round($percent / 100, 3),
                ];
            })
            ->sortByDesc('score')
            ->take(3)
            ->values();


        return response()->json([
                'ok' => true,
                'problem_summary' => null,
                'category' => null,
                'suggestions' => [],
            ]);
        }

        $structured = $this->fallbackStructuredProblem($inputText);

        $searchText = strtolower(trim(
            ($structured['problem_type'] ?? '') . ' ' .
            ($structured['category'] ?? '') . ' ' .
            implode(' ', $structured['symptoms'] ?? []) . ' ' .
            ($structured['likely_cause'] ?? '') . ' ' .
            ($structured['short_summary'] ?? '') . ' ' .
            $inputText
        ));

        $templates = ResolutionTemplate::where('is_active', true)->get();

        $scored = [];

        foreach ($templates as $template) {
            $haystack = strtolower(trim(
                ($template->title ?? '') . ' ' .
                ($template->category ?? '') . ' ' .
                ($template->symptom_keywords ?? '') . ' ' .
                ($template->resolution_steps ?? '')
            ));

            [$score, $matchedKeywords] = $this->calculateScore($searchText, $haystack);

            if ($score > 0.05) {
                $scored[] = [
                    'id' => $template->id,
                    'title' => $template->title,
                    'category' => $template->category,
                    'resolution_steps' => $template->resolution_steps,
                    'usage_count' => $template->usage_count,
                    'score' => $score,
                    'matched_keywords' => $matchedKeywords,
                    'reason' => $this->buildSuggestionReason($structured, $matchedKeywords),
                ];
            }
        }

        usort($scored, fn ($a, $b) => $b['score'] <=> $a['score']);

        return response()->json([
            'ok' => true,
            'problem_summary' => $structured['short_summary'] ?? Str::limit($inputText, 120),
            'category' => $structured['category'] ?? 'General',
            'suggestions' => array_slice($scored, 0, 3),
        ]);
    }

    private function fallbackStructuredProblem(string $inputText): array
    {
        $lower = strtolower($inputText);

        $category = 'General';
        if (str_contains($lower, 'monitor') || str_contains($lower, 'screen') || str_contains($lower, 'display') || str_contains($lower, 'tv')) {
            $category = 'Display';
        } elseif (str_contains($lower, 'power') || str_contains($lower, 'listrik') || str_contains($lower, 'mati') || str_contains($lower, 'adaptor')) {
            $category = 'Electrical';
        } elseif (str_contains($lower, 'network') || str_contains($lower, 'internet') || str_contains($lower, 'wifi')) {
            $category = 'Network';
        }

        return [
            'problem_type' => Str::limit($inputText, 80, ''),
            'category' => $category,
            'symptoms' => preg_split('/[\s,\.]+/', strtolower($inputText), -1, PREG_SPLIT_NO_EMPTY),
            'likely_cause' => 'Unknown',
            'short_summary' => Str::limit($inputText, 120),
        ];
    }

    private function calculateScore(string $searchText, string $haystack): array
    {
        similar_text($searchText, $haystack, $percent);

        $searchTokens = $this->tokens($searchText);
        $haystackTokens = $this->tokens($haystack);

        $intersection = array_values(array_unique(array_intersect($searchTokens, $haystackTokens)));

        $tokenScore = count($searchTokens) > 0
            ? count($intersection) / max(count(array_unique($searchTokens)), 1)
            : 0;

        $textScore = max(0, min(1, $percent / 100));
        $exactBoost = 0;

        foreach ($intersection as $token) {
            if (strlen($token) >= 5) {
                $exactBoost += 0.03;
            }
        }

        $final = ($textScore * 0.35) + ($tokenScore * 0.55) + min($exactBoost, 0.10);
        $final = max(0, min(1, $final));

        return [round($final, 5), $intersection];
    }

    private function buildSuggestionReason(array $structured, array $matchedKeywords): string
    {
        $parts = [];

        if (!empty($structured['category'])) {
            $parts[] = 'Category: ' . $structured['category'];
        }

        if (!empty($matchedKeywords)) {
            $parts[] = 'Matched keywords: ' . implode(', ', array_slice($matchedKeywords, 0, 6));
        }

        return empty($parts)
            ? 'Matched from known symptoms and resolution patterns.'
            : implode(' | ', $parts);
    }

    private function tokens(string $text): array
    {
        $tokens = preg_split('/[^a-z0-9]+/i', strtolower($text), -1, PREG_SPLIT_NO_EMPTY);

        $stopwords = [
            'dan','atau','yang','di','ke','dari','untuk','the','a','an','is','are',
            'tidak','ada','lagi','dengan','pada','saat','ini','itu',
            'description','title','problem','issue'
        ];

        return array_values(array_filter($tokens, function ($t) use ($stopwords) {
            return strlen($t) >= 3 && !in_array($t, $stopwords, true);
        }));
    }
}
