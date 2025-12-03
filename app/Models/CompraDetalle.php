<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    
    protected $table = 'compra_detalles';

    protected $fillable = [
        'compra_id','producto_id','cantidad','precio_compra','descuento','porc_ivas','iva','subtotal'
    ];

    public function compra() {
        return $this->belongsTo(Compra::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    
    
}
