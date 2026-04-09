<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemLog extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'photo',
        'engineer_name',
        'acknowledged_at',
        'opened_at',
        'in_progress_at',
        'closed_at',
        'close_note',
        'closed_photo',
    ];

    protected $casts = [
        'acknowledged_at' => 'datetime',
        'opened_at' => 'datetime',
        'in_progress_at' => 'datetime',
        'closed_at' => 'datetime',
    ];
}
