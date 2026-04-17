<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResolutionTemplate extends Model
{
    protected $fillable = [
        'title',
        'ai_title',
        'category',
        'ai_category',
        'canonical_group',
        'is_primary',
        'merged_from_titles',
        'symptom_keywords',
        'resolution_steps',
        'ai_summary',
        'ai_steps',
        'tools_needed',
        'parts_needed',
        'notes',
        'usage_count',
        'success_count',
        'last_used_at',
        'learning_score',
        'is_active',
        'ai_processed',
    ];

    protected $casts = [
        'ai_steps' => 'array',
        'is_active' => 'boolean',
        'ai_processed' => 'boolean',
        'is_primary' => 'boolean',
        'last_used_at' => 'datetime',
    ];

    public function images()
    {
        return $this->hasMany(\App\Models\ResolutionTemplateImage::class, 'resolution_template_id');
    }

    public function alternatives()
    {
        return $this->hasMany(self::class, 'canonical_group', 'canonical_group')
            ->where('id', '!=', $this->id)
            ->orderByDesc('learning_score')
            ->orderByDesc('usage_count');
    }

    public function displayTitle(): string
    {
        return $this->ai_title ?: $this->title ?: '-';
    }

    public function displayCategory(): string
    {
        return $this->ai_category ?: $this->category ?: '-';
    }

    public function displaySummary(): string
    {
        return $this->ai_summary ?: $this->resolution_steps ?: '-';
    }

    public function refreshLearningScore(): void
    {
        $score = ($this->usage_count * 1.5) + ($this->success_count * 3);
        $this->learning_score = round($score, 2);
        $this->save();
    }
}
