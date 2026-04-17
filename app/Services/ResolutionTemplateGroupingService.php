<?php

namespace App\Services;

use App\Models\ResolutionTemplate;

class ResolutionTemplateGroupingService
{
    public function regroupAll(): void
    {
        $templates = ResolutionTemplate::where('is_active', true)->get();

        $groups = [];

        foreach ($templates as $template) {
            $key = $this->buildCanonicalGroup($template);

            if (!isset($groups[$key])) {
                $groups[$key] = [];
            }

            $groups[$key][] = $template;
        }

        foreach ($groups as $key => $items) {
            usort($items, function ($a, $b) {
                return [$b->learning_score ?? 0, $b->usage_count ?? 0, $b->success_count ?? 0]
                    <=> [$a->learning_score ?? 0, $a->usage_count ?? 0, $a->success_count ?? 0];
            });

            $primary = $items[0] ?? null;
            $mergedTitles = collect($items)->map(fn ($i) => $i->displayTitle())->implode(' | ');

            foreach ($items as $idx => $item) {
                $item->canonical_group = $key;
                $item->is_primary = $primary ? ($item->id === $primary->id) : true;
                $item->merged_from_titles = count($items) > 1 ? $mergedTitles : null;
                $item->save();
            }
        }
    }

    public function buildCanonicalGroup(ResolutionTemplate $template): string
    {
        $text = strtolower(trim(
            ($template->displayTitle() ?? '') . ' ' .
            ($template->displayCategory() ?? '') . ' ' .
            ($template->symptom_keywords ?? '')
        ));

        $tokens = preg_split('/[^a-z0-9]+/i', $text, -1, PREG_SPLIT_NO_EMPTY);

        $stop = ['dan','atau','yang','screen','vendor','title','description','solusi','solution','display','the','and'];
        $tokens = array_values(array_filter($tokens, function ($t) use ($stop) {
            return strlen($t) >= 3 && !in_array($t, $stop, true);
        }));

        sort($tokens);

        return substr(md5(implode('|', array_slice(array_unique($tokens), 0, 8))), 0, 16);
    }
}
