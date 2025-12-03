<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    /** @use HasFactory<\Database\Factories\CompraFactory> */
    use HasFactory;

    protected $fillable = [
        'fecha','proveedor_id','nombre','numero_factura','empresa_id','porc_iva','subtotal','descuento','iva','total','estado'
    ];

   // Relación con Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    // Relación con Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    // Relación con Detalles
        
    public function detalles() {
        return $this->hasMany(CompraDetalle::class);
    }

}
