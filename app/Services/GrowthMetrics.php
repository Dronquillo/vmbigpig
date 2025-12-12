<?php

// app/Services/GrowthMetrics.php
namespace App\Services;

use App\Models\weight_records as WeightRecord;
use App\Models\feeding_events as FeedingEvent;

class GrowthMetrics {
    public static function adgForLot(int $lotId): float {
        $weights = WeightRecord::where('lot_id',$lotId)->orderBy('date')->get();
        if ($weights->count() < 2) return 0.0;
        $days = $weights->last()->date->diffInDays($weights->first()->date);
        if ($days <= 0) return 0.0;
        $gain = (float)$weights->last()->weight_kg - (float)$weights->first()->weight_kg;
        return round($gain / $days, 3);
    }

    public static function fcrForLot(int $lotId): float {
        $weights = WeightRecord::where('lot_id',$lotId)->orderBy('date')->get();
        if ($weights->count() < 2) return 0.0;
        $gain = (float)$weights->last()->weight_kg - (float)$weights->first()->weight_kg;
        if ($gain <= 0) return 0.0;
        $feed = (float)FeedingEvent::where('lot_id',$lotId)->sum('ration_actual_kg');
        return round($feed / $gain, 3);
    }
}


