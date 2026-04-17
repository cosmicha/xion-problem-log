<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResolutionTemplateImage extends Model
{
    protected $fillable = [
        'resolution_template_id',
        'image_path',
    ];

    public function resolutionTemplate()
    {
        return $this->belongsTo(ResolutionTemplate::class, 'resolution_template_id');
    }
}
