<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;


    public function imagen(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    // public function imagen() : Attribute
    // {
    //     return Attribute::make(
    //         get: function(){
    //             return $this->imagen ? Storage::url('public/'.$this->image->url) : asset('no-image.png');
    //         }
    //     );
    // }

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
   
    
}
