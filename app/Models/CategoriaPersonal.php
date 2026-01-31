<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaPersonal extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriaPersonalFactory> */
    use HasFactory;

    protected $fillable = ['nombre']; 
    
    public function personals() { return $this->hasMany(Personal::class, 'cargo_id'); }


}
