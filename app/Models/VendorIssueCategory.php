<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorIssueCategory extends Model
{
    protected $fillable = [
        'vendor_id',
        'name',
    ];

    public function vendor()
    {
        return $this->belongsTo(\App\Models\Vendor::class);
    }
}
