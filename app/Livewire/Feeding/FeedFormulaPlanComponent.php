<?php

namespace App\Livewire\Feeding;

use Livewire\Component;
use Livewire\Attributes\Title;

use App\Models\FeedFormula;
use App\Models\feed_items as FeedItem;
use App\Models\feeding_plans as FeedingPlan;
use App\Models\lots as Lot;

#[Title('Plan de formula de alimentacion')]

class FeedFormulaPlanComponent extends Component
{

public $formulas, $plans, $lots;
    public $totalRegistros;

    public function mount()
    {
        $this->formulas = FeedFormula::with('items.feedItem')->paginate(10);
        $this->plans = FeedingPlan::with('lot','feedFormula')->paginate(10);
        $this->lots = Lot::active()->get();
        $this->totalRegistros = $this->formulas->total();
    }

    public function render()
    {
        return view('livewire.feeding.feed-formula-plan-component', [
            'formulas' => $this->formulas,
            'plans' => $this->plans,
            'lots' => $this->lots
        ]);
    }



}
