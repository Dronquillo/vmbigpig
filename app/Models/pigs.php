<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\lots as Lot;
use App\Models\feeding_events as FeedingEvent;
use App\Models\weight_records as WeightRecord;
use App\Models\welfare_checks as WelfareCheck;

class pigs extends Model
{
    /** @use HasFactory<\Database\Factories\PigsFactory> */
    use HasFactory;

    protected $fillable = ['lot_id','code','sex','birth_date','status']; 
    public function lot() { return $this->belongsTo(Lot::class); } 
    public function feedingEvents() { return $this->hasMany(FeedingEvent::class); } 
    public function weightRecords() { return $this->hasMany(WeightRecord::class); } 
    public function welfareChecks() { return $this->hasMany(WelfareCheck::class); }


}
