<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePartMovement extends Model
{
    protected $fillable = [
        'spare_part_id',
        'from_location_id',
        'to_location_id',
        'ticket_id',
        'device_id',
        'user_id',
        'movement_type',
        'qty',
        'before_qty',
        'after_qty',
        'note',
    ];
}
