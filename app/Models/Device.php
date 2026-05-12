<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'company_id',
        'vendor_id',
        'device_code',
        'name',
        'category',
        'brand',
        'model',
        'serial_number',
        'site',
        'location',
        'status',
        'installation_date',
        'notes',
    ];

    protected $casts = [
        'installation_date' => 'date',
    ];

    // ✅ EXISTING RELATIONS (WAJIB ADA)
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function images()
    {
        return $this->hasMany(\App\Models\DeviceImage::class);
    }

    public function problemLogs()
    {
        return $this->hasMany(\App\Models\ProblemLog::class);
    }

    // ✅ NEW RELATION (VENDOR)
    public function vendor()
    {
        return $this->belongsTo(\App\Models\Vendor::class);
    }

    public function qrImageUrl()
    {
        $qrValue = url('/problem-logs/create?device_id=' . $this->id);

        return 'https://api.qrserver.com/v1/create-qr-code/?size=600x600&margin=0&data=' . urlencode($qrValue);
    }


    public function currentLocation()
    {
        return $this->belongsTo(\App\Models\InventoryLocation::class, 'current_location_id');
    }

    public function movements()
    {
        return $this->hasMany(\App\Models\DeviceMovement::class);
    }
}
