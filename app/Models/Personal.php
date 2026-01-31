<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    /** @use HasFactory<\Database\Factories\PersonalFactory> */
    use HasFactory;

    protected $fillable = [ 'nombre', 'apellido', 'email', 'telefono', 'fecha_ingreso', 'fecha_salida', 'estado', 'cargo_id', ]; 
    
    public function categoria() { return $this->belongsTo(CategoriaPersonal::class, 'cargo_id'); }

}
