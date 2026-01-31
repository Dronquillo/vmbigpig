<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedFormula extends Model
{
    protected $fillable = ['name','notes'];

    public function items()
    {
        return $this->hasMany(FeedFormulaItem::class, 'feed_formula_id');
    }
}

