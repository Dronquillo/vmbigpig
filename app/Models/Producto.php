<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CompraDetalle;
use App\Models\feed_formulas_items as FeedFormulaItem;     

use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [ 'nombre','descripcion','precio','stock','stock_minimo','con_iva', 'lote','fecha_vencimiento','codigo_barras','categoria_id','estado' ];

    public function imagen(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function category(){
        return $this->belongsTo('App\Models\Categoria','categoria_id');
    }   

    protected function stockLabel() : Attribute 
    {
        return Attribute::make(
            get: function(){
                return $this->attributes['stock'] >= $this->attributes['stock_minimo'] ? 
                       '<span class="badge badge-pill badge-success">'.$this->attributes['stock'].'</span>' : 
                       '<span class="badge badge-pill badge-danger">'.$this->attributes['stock'].'</span>';


            }
        );
    }   

    protected function precio() : Attribute
    {
        return Attribute::make(
            get: function(){
                return '<b>$ '.number_format($this->attributes['precio'],0,',','.').'</b>';
            }
        );
    }   
    
    protected function activeLabel() : Attribute
    {
        return Attribute::make(
            get: function(){
                return $this->attributes['estado'] ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-warning">Inactivo</span>';
            }
        );
    }
   
    public function compraDetalles() { return $this->hasMany(CompraDetalle::class, 'producto_id'); } 
    public function feedFormulaItems() { return $this->hasMany(FeedFormulaItem::class, 'producto_id'); }


}
