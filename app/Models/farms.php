<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Barns as Barn;

class farms extends Model
{
    /** @use HasFactory<\Database\Factories\FarmsFactory> */
    use HasFactory;

    protected $fillable = ['name', 'location', 'owner', 'estado']; // ajusta según tu esquema

    public function barns() { return $this->hasMany(Barn::class); } 
    
}
