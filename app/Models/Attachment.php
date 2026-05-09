<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'attachment_group',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'uploaded_by_user_id',
    ];

    public function attachable()
    {
        return $this->morphTo();
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }
}
