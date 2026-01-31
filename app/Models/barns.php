<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\farms as Farm;
use App\Models\lots as Lot;


class barns extends Model
{
    /** @use HasFactory<\Database\Factories\BarnsFactory> */
    use HasFactory;

    protected $table = 'barns';
    
    protected $fillable = ['farm_id', 'name', 'type', 'capacity']; 
    
    public function farm() { return $this->belongsTo(Farm::class); } 
    
    public function lots() { return $this->hasMany(Lot::class, 'barn_id'); } 

    // Tipos soportados 
    public static function types(): array { return ['General', 'Parto', 'Guarderia', 'Finalizado']; }





}
