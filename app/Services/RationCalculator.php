<?php
// app/Services/RationCalculator.php
namespace App\Services;

use App\Models\feed_formulas as FeedFormula;
use Illuminate\Support\Collection;

class RationCalculator
{
    // Devuelve composición por producto en kg y costo estimado con precio producto->precio
    public function breakdown(FeedFormula $formula, float $rationKg, int $heads): array
    {
        $totalKg = $rationKg * $heads;
        $items = $formula->items()->with('producto')->get();

        $composition = [];
        $costTotal = 0.0;

        foreach ($items as $item) {
            $kg = round($totalKg * ($item->percentage / 100.0), 3);
            $unitPrice = (float) $item->producto->precio; // puedes usar costo promedio compra
            $cost = round($kg * $unitPrice, 4);
            $composition[] = [
                'producto_id' => $item->producto_id,
                'percentage' => $item->percentage,
                'kg' => $kg,
                'unit_price' => $unitPrice,
                'cost' => $cost,
            ];
            $costTotal += $cost;
        }

        return ['composition' => $composition, 'cost_total' => round($costTotal, 4)];
    }
}
