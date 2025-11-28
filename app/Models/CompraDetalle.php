<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    
    protected $fillable = [
        'compra_id','producto_id','cantidad','precio_compra','descuento','iva','subtotal','porc_ivas'
    ];

    public function compra() {
        return $this->belongsTo(Compra::class);
    }

}
