<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaPartoEstado extends Model
{
    //
    use HasFactory;

    protected $table = 'tabla_parto_estados'; 

    protected $fillable = ['id_parto','numero_camada','genero','estado','observaciones']; 
    
    public function parto() { return $this->belongsTo(TablaPartos::class, 'id_parto'); }


}
