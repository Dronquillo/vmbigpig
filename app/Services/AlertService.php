<?php 

// app/Services/AlertService.php
namespace App\Services;

use App\Models\alerts_and_audit_logs as Alert;

class AlertService {
    public static function weightStall(int $lotId, float $adg, float $threshold = 0.6): void {
        if ($adg > 0 && $adg < $threshold) {
            Alert::create([
                'type' => 'weight_stall',
                'level' => 'warning',
                'alertable_type' => 'App\Models\Lot',
                'alertable_id' => $lotId,
                'data' => ['adg' => $adg, 'threshold' => $threshold],
            ]);
        }
    }
}

