<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class image extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'url',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
    
}