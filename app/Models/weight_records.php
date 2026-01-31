<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\lots as Lot;
use App\Models\Activovivo as Pig;

class weight_records extends Model
{
    /** @use HasFactory<\Database\Factories\WeightRecordsFactory> */
    use HasFactory;

    protected $table = 'weight_records';

    protected $fillable = ['pig_id','lot_id','date','weight_kg']; 

    protected $casts = ['date'=>'date']; 

    public function pig() { return $this->belongsTo(Pig::class); } 
    public function lot() { return $this->belongsTo(Lot::class); }

}
