<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\lots as Lot;
use App\Models\Activovivo as Pig;

class welfare_checks extends Model
{
    /** @use HasFactory<\Database\Factories\WelfareChecksFactory> */
    use HasFactory;

    protected $table = 'welfare_checks';

    protected $fillable = ['pig_id','lot_id','date','condition','severity','notes','vet_required']; 

    protected $casts = ['date'=>'date','vet_required'=>'bool']; 

    public function pig() { return $this->belongsTo(Pig::class); } 
    public function lot() { return $this->belongsTo(Lot::class); }

}
