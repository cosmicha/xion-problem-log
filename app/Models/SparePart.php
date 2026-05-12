<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'category',
        'brand',
        'vendor_id',
        'location_id',
        'stock_qty',
        'minimum_stock',
        'unit_cost',
        'status',
        'notes',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function location()
    {
        return $this->belongsTo(InventoryLocation::class, 'location_id');
    }
}
