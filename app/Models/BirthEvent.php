<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthEvent extends Model
{
    //
    use HasFactory;

    protected $fillable = [ 
        'activovivo_id', // madre 
        'date', 
        'litter_size', 
        'notes', 
    ]; 
    
    /** * Relación: cada parto pertenece a una madre (Activovivo). */ 
    public function activovivo() 
    { 
        return $this->belongsTo(Activovivo::class); 
    } 
    
    /** * Scope: partos recientes (últimos 30 días). */ 
    public function scopeRecientes($query) 
    { 
        return $query->where('date', '>=', now()->subDays(30)); 
    }

}
