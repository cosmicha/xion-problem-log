<?php

namespace App\Services;

use App\Models\ProblemLog;
use App\Models\ProblemLogAiSuggestion;
use App\Models\ResolutionTemplate;
use Illuminate\Support\Str;
use OpenAI;

class OpenAiResolutionSuggestionService
{
    public function process(ProblemLog $problemLog): void
    {
        $inputText = trim(($problemLog->title ?? '') . ' ' . ($problemLog->description ?? ''));

        if ($inputText === '') {
            return;
        }

        $structured = $this->extractStructuredProblem($inputText);

        $searchText = strtolower(trim(
            ($structured['problem_type'] ?? '') . ' ' .
            ($structured['category'] ?? '') . ' ' .
            implode(' ', $structured['symptoms'] ?? []) . ' ' .
            ($structured['likely_cause'] ?? '') . ' ' .
            ($structured['short_summary'] ?? '') . ' ' .
            $inputText
        ));

        $templates = ResolutionTemplate::where('is_active', true)->get();

        ProblemLogAiSuggestion::where('problem_log_id', $problemLog->id)->delete();

        $scored = [];

        foreach ($templates as $template) {
            $haystack = strtolower(trim(
                ($template->title ?? '') . ' ' .
                ($template->category ?? '') . ' ' .
                ($template->symptom_keywords ?? '') . ' ' .
                ($template->resolution_steps ?? '')
            ));

            [$score, $matchedKeywords] = $this->calculateScore($searchText, $haystack);

            if ($score > 0) {
                $scored[] = [
                    'template' => $template,
                    'score' => $score,
                    'matched_keywords' => $matchedKeywords,
                ];
            }
        }

        usort($scored, fn ($a, $b) => $b['score'] <=> $a['score']);

        foreach (array_slice($scored, 0, 3) as $row) {
            ProblemLogAiSuggestion::create([
                'problem_log_id' => $problemLog->id,
                'resolution_template_id' => $row['template']->id,
                'problem_summary' => $structured['short_summary'] ?? Str::limit($inputText, 120),
                'suggestion_reason' => $this->buildSuggestionReason($structured, $row['matched_keywords']),
                'matched_keywords' => implode(', ', $row['matched_keywords']),
                'similarity_score' => $row['score'],
                'structured_problem' => $structured,
            ]);
        }
    }

    private function extractStructuredProblem(string $inputText): array
    {
        try {
            $apiKey = config('services.openai.api_key');

            if (!$apiKey) {
                return $this->fallbackStructuredProblem($inputText);
            }

            $client = OpenAI::client($apiKey);

            $response = $client->responses()->create([
                'model' => env('OPENAI_MODEL', 'gpt-5.4-mini'),
                'input' => [
                    [
                        'role' => 'system',
                        'content' => [
                            [
                                'type' => 'input_text',
                                'text' => 'Extract the maintenance problem into structured JSON with keys: problem_type, category, symptoms, likely_cause, short_summary.'
                            ]
                        ]
                    ],
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'input_text',
                                'text' => $inputText
                            ]
                        ]
                    ]
                ],
                'text' => [
                    'format' => [
                        'type' => 'json_schema',
                        'name' => 'problem_structure',
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'problem_type' => ['type' => 'string'],
                                'category' => ['type' => 'string'],
                                'symptoms' => ['type' => 'array', 'items' => ['type' => 'string']],
                                'likely_cause' => ['type' => 'string'],
                                'short_summary' => ['type' => 'string'],
                            ],
                            'required' => ['problem_type', 'category', 'symptoms', 'likely_cause', 'short_summary'],
                            'additionalProperties' => false,
                        ],
                        'strict' => true,
                    ],
                ],
            ]);

            $parsed = json_decode($response->output_text ?? '{}', true);

            if (!is_array($parsed) || empty($parsed)) {
                return $this->fallbackStructuredProblem($inputText);
            }

            return $parsed;
        } catch (\Throwable $e) {
            \Log::error('OpenAI structured extraction failed', [
                'error' => $e->getMessage(),
            ]);

            return $this->fallbackStructuredProblem($inputText);
        }
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
