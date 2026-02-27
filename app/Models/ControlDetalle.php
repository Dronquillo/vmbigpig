<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlDetalle extends Model
{
    protected $fillable = ['control_id','producto_id','cantidad','precio','subtotal'];

    public function control() { return $this->belongsTo(Control::class); }
    public function producto() { return $this->belongsTo(Producto::class); }
    
}
