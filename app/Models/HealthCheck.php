<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCheck extends Model
{
    //
    use HasFactory;

    protected $table = 'health_checks';

    protected $fillable = [ 
        'activovivo_id', 
        'date', 
        'observations', 
        'status', 
    ]; 
    
    /** * Relación: cada chequeo pertenece a un animal (Activovivo). */ 
    public function activovivo() 
    { 
        return $this->belongsTo(Activovivo::class); 
    } 
    
    /** * Scope: chequeos con estado crítico. */ 
    public function scopeCriticos($query) 
    { 
        return $query->where('status', '!=', 'ok'); 
    }

}
