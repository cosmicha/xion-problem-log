<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceImage extends Model
{
    protected $fillable = [
        'device_id',
        'path',
        'caption',
        'sort_order',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
