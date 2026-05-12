<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceMovement extends Model
{
    protected $fillable = [
        'device_id',
        'from_location_id',
        'to_location_id',
        'ticket_id',
        'user_id',
        'movement_type',
        'note',
    ];

    public function device()
    {
        return $this->belongsTo(\App\Models\Device::class);
    }

    public function fromLocation()
    {
        return $this->belongsTo(\App\Models\InventoryLocation::class, 'from_location_id');
    }

    public function toLocation()
    {
        return $this->belongsTo(\App\Models\InventoryLocation::class, 'to_location_id');
    }
}
