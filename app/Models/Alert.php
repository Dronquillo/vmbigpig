<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'level',
        'alertable_type',
        'alertable_id',
        'data',
        'resolved',
    ];

    protected $casts = [
        'data' => 'array',
        'resolved' => 'boolean',
    ];

    public function alertable()
    {
        return $this->morphTo();
    }
}
