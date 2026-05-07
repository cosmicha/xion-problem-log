<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'code',
        'contact_person',
        'email',
        'phone',
        'address',
        'category',
        'status',
        'notes',
        'coverage_type',
        'scope_of_work',
        'sow',
        'telegram_chat_id',
    ];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function problemLogs()
    {
        return $this->hasMany(ProblemLog::class);
    }

    public function issueCategories()
    {
        return $this->hasMany(VendorIssueCategory::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
