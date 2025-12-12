<?php 
// app/Services/FeedingCalculator.php
namespace App\Services;

use App\Models\Lots as Lot;
use App\Models\feed_formulas as FeedFormula;

class FeedingCalculator {
    public static function targetForLot(Lot $lot, FeedFormula $formula, float $rationPerPigKg): array {
        $count = $lot->current_count;
        $targetKg = round($count * $rationPerPigKg, 3);
        $composition = [];
        foreach ($formula->items as $i) {
            $kg = round($targetKg * ($i->percentage / 100), 3);
            $composition[] = [
                'feed_item_id' => $i->feed_item_id,
                'kg' => $kg,
                'cost_usd' => round($kg * (float)$i->feedItem->cost_per_unit, 4),
            ];
        }
        $costTotal = collect($composition)->sum('cost_usd');
        return ['targetKg' => $targetKg, 'composition' => $composition, 'costTotal' => round($costTotal,4)];
    }
}
