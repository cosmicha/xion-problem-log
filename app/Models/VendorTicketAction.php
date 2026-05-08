<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorTicketAction extends Model
{
    protected $fillable = [
        'problem_log_id',
        'vendor_id',
        'user_id',
        'action',
        'note',
    ];

    public function problemLog()
    {
        return $this->belongsTo(ProblemLog::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
