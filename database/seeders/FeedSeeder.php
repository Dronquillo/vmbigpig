<?php

// database/seeders/FeedSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\feed_items as FeedItem;
use App\Models\feed_formulas as FeedFormula;
use App\Models\feed_items as FeedFormulaItem;

class FeedSeeder extends Seeder {
    public function run(): void {
        $corn = FeedItem::create(['name'=>'Maíz', 'cost_per_unit'=>0.35, 'stock'=>500]);
        $soy = FeedItem::create(['name'=>'Soya', 'cost_per_unit'=>0.60, 'stock'=>300]);
        $premix = FeedItem::create(['name'=>'Premix', 'cost_per_unit'=>1.20, 'stock'=>50]);

        $starter = FeedFormula::create(['name'=>'Starter']);
        FeedFormulaItem::create(['feed_formula_id'=>$starter->id,'feed_item_id'=>$corn->id,'percentage'=>55]);
        FeedFormulaItem::create(['feed_formula_id'=>$starter->id,'feed_item_id'=>$soy->id,'percentage'=>35]);
        FeedFormulaItem::create(['feed_formula_id'=>$starter->id,'feed_item_id'=>$premix->id,'percentage'=>10]);

        $grower = FeedFormula::create(['name'=>'Grower']);
        FeedFormulaItem::create(['feed_formula_id'=>$grower->id,'feed_item_id'=>$corn->id,'percentage'=>65]);
        FeedFormulaItem::create(['feed_formula_id'=>$grower->id,'feed_item_id'=>$soy->id,'percentage'=>30]);
        FeedFormulaItem::create(['feed_formula_id'=>$grower->id,'feed_item_id'=>$premix->id,'percentage'=>5]);
    }
}

