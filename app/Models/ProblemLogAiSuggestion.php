<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemLogAiSuggestion extends Model
{
    protected $fillable = [
        'problem_log_id',
        'resolution_template_id',
        'problem_summary',
        'suggestion_reason',
        'matched_keywords',
        'similarity_score',
        'structured_problem',
    ];

    protected $casts = [
        'structured_problem' => 'array',
    ];

    public function resolutionTemplate()
    {
        return $this->belongsTo(ResolutionTemplate::class, 'resolution_template_id');
    }

    public function problemLog()
    {
        return $this->belongsTo(ProblemLog::class);
    }
}
