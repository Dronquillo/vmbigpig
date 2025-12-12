<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\feed_formulas as FeedFormulaItem;

class feed_formulas extends Model
{
    /** @use HasFactory<\Database\Factories\FeedFormulasFactory> */
    use HasFactory;

    protected $fillable = ['name','notes'];
    public function items(){ return $this->hasMany(FeedFormulaItem::class); }
    public function costPerKg(): float {
        return $this->items->sum(fn($i) => ($i->percentage/100) * $i->feedItem->cost_per_unit);
    }


}
