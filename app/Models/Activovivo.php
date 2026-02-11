<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\lots as Lot;

class Activovivo extends Model
{
    /** @use HasFactory<\Database\Factories\ActivovivoFactory> */
    use HasFactory;

    protected $table = 'activovivos';

    protected $fillable = [
        'codigo','nombre','fecha_nacimiento','hora_nacimiento','numero_camada',
        'color','especie','raza','genero','peso','medida_id','estado_salud',
        'categoria_id','empresa_id','estado'
    ];

    protected $casts = [ 
        'fecha_nacimiento' => 'date', 
        'hora_nacimiento' => 'datetime:H:i', 
    ];    

    public function lot()
    {
        return $this->belongsTo(Lot::class, 'lot_id');
        
    }

    
}
