<?php

namespace App\Services;

use App\Models\ResolutionTemplate;
use OpenAI;

class OpenAiResolutionTemplateRefinerService
{
    public function process(ResolutionTemplate $template): void
    {
        $sourceText = trim(
            ($template->title ?? '') . "\n" .
            ($template->symptom_keywords ?? '') . "\n" .
            ($template->resolution_steps ?? '')
        );

        if ($sourceText === '') {
            return;
        }

        $data = $this->extractStructuredResolution($template, $sourceText);

        $template->update([
            'ai_title' => $data['title'] ?? $template->title,
            'ai_summary' => $data['summary'] ?? $template->resolution_steps,
            'ai_steps' => $data['steps'] ?? [],
            'ai_category' => $data['category'] ?? $template->category,
            'ai_processed' => true,
        ]);
    }

    private function extractStructuredResolution(ResolutionTemplate $template, string $sourceText): array
    {
        try {
            $apiKey = config('services.openai.api_key');

            if (!$apiKey) {
                return $this->fallback($template, $sourceText);
            }

            $client = OpenAI::client($apiKey);

            $prompt = "You are cleaning a technical maintenance resolution knowledge base entry.

Return clean JSON with:
- title: short, professional, reusable KB title
- summary: 2-4 sentences, clear and descriptive, no repetition
- steps: array of concise actionable steps, deduplicated
- category: short category like Display, Electrical, Network, Hardware, Software, Other

Important:
- remove repeated phrases
- make it reusable and knowledge-base style
- do not simply copy raw text
- if the input is short, infer a cleaner explanation from the title/symptoms/resolution
";

            $response = $client->responses()->create([
                'model' => env('OPENAI_MODEL', 'gpt-5.4-mini'),
                'input' => [
                    [
                        'role' => 'system',
                        'content' => [[
                            'type' => 'input_text',
                            'text' => $prompt
                        ]]
                    ],
                    [
                        'role' => 'user',
                        'content' => [[
                            'type' => 'input_text',
                            'text' => $sourceText
                        ]]
                    ]
                ],
                'text' => [
                    'format' => [
                        'type' => 'json_schema',
                        'name' => 'resolution_structure',
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'title' => ['type' => 'string'],
                                'summary' => ['type' => 'string'],
                                'steps' => [
                                    'type' => 'array',
                                    'items' => ['type' => 'string']
                                ],
                                'category' => ['type' => 'string'],
                            ],
                            'required' => ['title', 'summary', 'steps', 'category'],
                            'additionalProperties' => false,
                        ],
                        'strict' => true,
                    ],
                ],
            ]);

            $parsed = json_decode($response->output_text ?? '{}', true);

            if (!is_array($parsed) || empty($parsed)) {
                return $this->fallback($template, $sourceText);
            }

            $parsed['steps'] = $this->cleanSteps($parsed['steps'] ?? []);
            $parsed['summary'] = $this->cleanSummary((string) ($parsed['summary'] ?? ''));

            return $parsed;
        } catch (\Throwable $e) {
            \Log::error('Resolution template refine failed', [
                'template_id' => $template->id,
                'error' => $e->getMessage(),
            ]);

            return $this->fallback($template, $sourceText);
        }
    }

    private function fallback(ResolutionTemplate $template, string $sourceText): array
    {
        $title = trim((string) ($template->title ?: 'Resolution'));
        $symptoms = trim((string) ($template->symptom_keywords ?: ''));
        $stepsRaw = trim((string) ($template->resolution_steps ?: $sourceText));

        $steps = $this->cleanSteps(
            preg_split('/[\r\n;\.]+/', $stepsRaw, -1, PREG_SPLIT_NO_EMPTY) ?: []
        );

        $summaryParts = [];

        if ($title !== '') {
            $summaryParts[] = "Issue handled: {$title}.";
        }

        if ($symptoms !== '') {
            $summaryParts[] = "Symptoms observed: " . rtrim($symptoms, ".") . ".";
        }

        if (!empty($steps)) {
            $summaryParts[] = "Resolution performed: " . rtrim($steps[0], ".") . ".";
        }

        if (count($steps) > 1) {
            $summaryParts[] = "Final verification and completion were performed after the replacement or corrective action.";
        }

        $summary = $this->cleanSummary(implode(' ', $summaryParts));

        return [
            'title' => $this->buildBetterTitle($title, $symptoms, $steps),
            'summary' => $summary !== '' ? $summary : $stepsRaw,
            'steps' => $steps,
            'category' => $this->inferCategory($title . ' ' . $symptoms . ' ' . $stepsRaw),
        ];
    }

    private function buildBetterTitle(string $title, string $symptoms, array $steps): string
    {
        $base = trim($title);

        if ($base === '' && !empty($steps)) {
            $base = $steps[0];
        }

        if ($base === '') {
            $base = 'General Maintenance Resolution';
        }

        return ucwords(trim($base));
    }

    private function inferCategory(string $text): string
    {
        $lower = strtolower($text);

        if (str_contains($lower, 'screen') || str_contains($lower, 'monitor') || str_contains($lower, 'display') || str_contains($lower, 'tv')) {
            return 'Display';
        }

        if (str_contains($lower, 'saklar') || str_contains($lower, 'power') || str_contains($lower, 'listrik') || str_contains($lower, 'adaptor')) {
            return 'Electrical';
        }

        if (str_contains($lower, 'network') || str_contains($lower, 'internet') || str_contains($lower, 'wifi')) {
            return 'Network';
        }

        if (str_contains($lower, 'software') || str_contains($lower, 'system') || str_contains($lower, 'cms')) {
            return 'Software';
        }

        return 'Hardware';
    }

    private function cleanSteps(array $steps): array
    {
        $clean = [];
        $seen = [];

        foreach ($steps as $step) {
            $step = trim((string) $step);
            $step = preg_replace('/\s+/', ' ', $step);

            if ($step === '' || $step === '-') {
                continue;
            }

            $key = strtolower($step);
            if (isset($seen[$key])) {
                continue;
            }

            $seen[$key] = true;
            $clean[] = ucfirst(rtrim($step, '.')) . '.';
        }

        return array_values($clean);
    }

    private function cleanSummary(string $summary): string
    {
        $summary = trim($summary);
        $summary = preg_replace('/\s+/', ' ', $summary);

        if ($summary === '') {
            return '';
        }

        $parts = preg_split('/(?<=[\.\!\?])\s+/', $summary) ?: [];
        $seen = [];
        $clean = [];

        foreach ($parts as $part) {
            $part = trim($part);
            if ($part === '') {
                continue;
            }

            $key = strtolower($part);
            if (isset($seen[$key])) {
                continue;
            }

            $seen[$key] = true;
            $clean[] = $part;
        }

        return implode(' ', $clean);
    }
}
