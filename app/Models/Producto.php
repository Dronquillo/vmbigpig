<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;


    public function image(){
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function category(){
        return $this->belongsTo('App\Models\Categoria','categoria_id');
    }   

    protected function stockLabel() : Attribute
    {
        return Attribute::make(
            get: function(){
                if($this->attributes['stock'] <= $this->attributes['stock_minimo']){
                    return '<span class="badge badge-danger">'.$this->attributes['stock'].'</span>';
                }else{
                    return '<span class="badge badge-success">'.$this->attributes['stock'].'</span>';
                }
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
                return $this->attributes['activo'] ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-warning">Inactivo</span>';
            }
        );
    }

    public function imagen() : Attribute
    {
        return Attribute::make(
            get: function(){
                return $this->image ? Storage::url('public/'.$this->image->url) : asset('no-image.png');
            }
        );
    }
    
    
}
