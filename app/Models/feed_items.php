<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\suppliers as Supplier;


class feed_items extends Model
{
    /** @use HasFactory<\Database\Factories\FeedItemsFactory> */
    use HasFactory;

    protected $fillable = ['supplier_id','name','unit','cost_per_unit','stock'];
    protected $casts = ['cost_per_unit'=>'decimal:4','stock'=>'decimal:3'];
    public function supplier(){ return $this->belongsTo(Supplier::class); }


}
