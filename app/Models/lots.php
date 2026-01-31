<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Activovivo;
use App\Models\Barns as Barn;
use App\Models\feeding_plans as FeedingPlan;
use App\Models\feeding_events as FeedingEvent;
use App\Models\weight_records as WeightRecord;
use App\Models\welfare_checks as WelfareCheck;
use App\Models\TablaPartos as tabla_partos;

class lots extends Model
{
    /** @use HasFactory<\Database\Factories\LotsFactory> */
    use HasFactory;
    protected $table = 'lots';

    protected $fillable = ['barn_id','code','start_date','end_date','initial_count','current_count'];

    protected $casts = ['start_date'=>'date','end_date'=>'date'];

    public function barn(){ return $this->belongsTo(Barn::class); }

    public function pigs(){ return $this->hasMany(Activovivo::class, 'lot_id'); }

    public function feedingPlans(){ return $this->hasMany(FeedingPlan::class); }

    public function feedingEvents(){ return $this->hasMany(FeedingEvent::class); }

    public function weightRecords(){ return $this->hasMany(WeightRecord::class); }

    public function welfareChecks(){ return $this->hasMany(WelfareCheck::class); }

    public function scopeActive($q){ return $q->whereNull('end_date'); }

    public function dayOfCycle(): int { return now()->diffInDays($this->start_date); }

    public function partos() { return $this->hasMany(tabla_partos::class, 'id_activo'); } // si lot->id = activovivos->id (si difiere, ajusta)

}

