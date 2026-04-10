<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'code',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function problemLogs()
    {
        return $this->hasMany(ProblemLog::class);
    }
}
