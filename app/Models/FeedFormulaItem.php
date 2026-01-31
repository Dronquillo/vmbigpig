<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedFormulaItem extends Model
{
    protected $table = 'feed_formula_items';
    protected $fillable = ['feed_formula_id','producto_id','cantidad','medida_id','percentage'];

    public function formula()
    {
        return $this->belongsTo(FeedFormula::class, 'feed_formula_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function medida()
    {
        return $this->belongsTo(TablaMedida::class, 'medida_id');
    }

}    

