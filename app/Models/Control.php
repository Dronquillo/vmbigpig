<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{

    protected $table = 'controles';
    
    protected $casts = ['fecha'=>'date',];

    protected $fillable = [
        'lot_id','activovivo_id','empresa_id','tipo','descripcion','cantidad','costo','fecha','hora', 
        'tipo_inseminacion','fecha_preñez','macho_id','veterinario_costo'
    ];

    public function lot() { return $this->belongsTo(lots::class); }
    public function animal() { return $this->belongsTo(Activovivo::class,'activovivo_id'); }
    public function empresa() { return $this->belongsTo(Empresa::class); }
    public function detalles() { return $this->hasMany(ControlDetalle::class);  }
    public function macho() { return $this->belongsTo(Activovivo::class, 'macho_id'); }

}

