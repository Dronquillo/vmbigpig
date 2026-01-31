<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaPartos extends Model
{
    /** @use HasFactory<\Database\Factories\TablaPartosFactory> */
    use HasFactory;

    protected $table = 'tabla_partos';

    protected $fillable = [ 
        'id_activo', 
        'numero_camada',  
        'reproductor', 
        'fecha_parto', 
        'hora_parto', 
        'id_personal', 
        'numero_crias', 
        'observaciones', 
        'estado', 
    ]; 

    protected $casts = [ 
        'fecha_parto' => 'date', 
        'hora_parto' => 'datetime:H:i', 
    ]; 

    public function estados() { return $this->hasMany(TablaPartoEstado::class, 'id_parto'); } 
    public function activo() { return $this->belongsTo(ActivoVivo::class, 'id_activo'); } 
    public function personal(){ return $this->belongsTo(Personal::class, 'id_personal'); }
    
}
