<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'device_code',
        'cms_device_name',
        'company_id',
        'vendor_id',
        'device_type_id',
        'location_name',
        'location_detail',
        'serial_number',
        'ip_address',
        'is_active',
        'notes'
    ];

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function vendor()
    {
        return $this->belongsTo(\App\Models\Vendor::class);
    }

    public function deviceType()
    {
        return $this->belongsTo(\App\Models\DeviceType::class);
    }
}
