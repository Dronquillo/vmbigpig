<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\lots as Lot;
use App\Models\FeedFormula;

class feeding_plans extends Model
{
    /** @use HasFactory<\Database\Factories\FeedingPlansFactory> */
    use HasFactory;

    protected $table = 'feeding_plans';

    protected $fillable = ['lot_id','formula_id','day_from','day_to','ration_per_pig_kg']; 

    public function lot() { return $this->belongsTo(Lot::class); } 

    public function formula() { return $this->belongsTo(FeedFormula::class, 'formula_id'); }

}
