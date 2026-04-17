<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemLogResolution extends Model
{
    protected $fillable = [
        'problem_log_id',
        'resolution_template_id',
        'resolution_input',
        'type',
    ];

    public function template()
    {
        return $this->belongsTo(ResolutionTemplate::class, 'resolution_template_id');
    }

    public function problemLog()
    {
        return $this->belongsTo(ProblemLog::class);
    }
}
