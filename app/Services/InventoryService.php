<?php

// app/Services/InventoryService.php
namespace App\Services;

use App\Models\feed_items as FeedItem;
use App\Models\alerts_and_audit_logs as Alert;

class InventoryService {
    public static function consume(array $composition): void {
        foreach ($composition as $line) {
            $item = FeedItem::find($line['feed_item_id']);
            if (!$item) continue;
            $newStock = max(0, (float)$item->stock - (float)$line['kg']);
            $item->update(['stock' => $newStock]);

            if ($newStock < 50) { // umbral ejemplo
                Alert::create([
                    'type' => 'stock_low',
                    'level' => $newStock < 10 ? 'critical' : 'warning',
                    'alertable_type' => FeedItem::class,
                    'alertable_id' => $item->id,
                    'data' => ['stock' => $newStock, 'threshold' => 50],
                ]);
            }
        }
    }
}

