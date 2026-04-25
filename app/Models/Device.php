<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'company_id',
        'device_code',
        'name',
        'category',
        'brand',
        'model',
        'serial_number',
        'site',
        'location',
        'status',
        'notes',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function problemLogs()
    {
        return $this->hasMany(ProblemLog::class);
    }

    public function images()
    {
        return $this->hasMany(DeviceImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function coverImage()
    {
        return $this->images()->first();
    }

    public function ticketCreateUrl(): string
    {
        return url('/problem-logs/create?device_id=' . $this->id);
    }

    public function qrImageUrl(): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=320x320&data=' . urlencode($this->ticketCreateUrl());
    }
}
