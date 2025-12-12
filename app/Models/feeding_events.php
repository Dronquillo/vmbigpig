<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\lots as Lot;
use App\Models\pigs as Pig;

class feeding_events extends Model
{
    /** @use HasFactory<\Database\Factories\FeedingEventsFactory> */
    use HasFactory;

        protected $fillable = [
        'lot_id','pig_id','date','ration_target_kg','ration_actual_kg','waste_kg','cost_usd','composition'
    ];
    protected $casts = ['date'=>'date','composition'=>'array'];
    public function lot(){ return $this->belongsTo(Lot::class); }
    public function pig(){ return $this->belongsTo(Pig::class); }


}
