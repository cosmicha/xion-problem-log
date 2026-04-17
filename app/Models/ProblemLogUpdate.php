<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemLogUpdate extends Model
{
    protected $fillable = [
        'problem_log_id',
        'user_id',
        'type',
        'message',
        'old_status',
        'new_status',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function problemLog()
    {
        return $this->belongsTo(ProblemLog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
