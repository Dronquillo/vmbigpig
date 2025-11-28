<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    /** @use HasFactory<\Database\Factories\CompraFactory> */
    use HasFactory;

    protected $fillable = [
        'proveedor_id','nombre','numero_factura','empresa_id','fecha','porc_iva','subtotal','descuento','iva','total','estado'
    ];

    public function detalles() {
        return $this->hasMany(CompraDetalle::class);
    }

}
