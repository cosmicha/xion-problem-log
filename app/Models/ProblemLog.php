<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemLog extends Model
{
    protected $fillable = [
        'company_id',
        'assigned_engineer_id',
        'ticket_number',
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function assignedEngineer()
    {
        return $this->belongsTo(User::class, 'assigned_engineer_id');
    }
}
