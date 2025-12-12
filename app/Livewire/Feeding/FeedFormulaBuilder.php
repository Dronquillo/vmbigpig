<?php

namespace App\Livewire\Feeding;
use Livewire\Attributes\Title;

use Livewire\Component;

#[Title('Constructor de formulas de alimento')]

class FeedFormulaBuilder extends Component
{
    public function render()
    {
        return view('livewire.feeding.feed-formula-builder');
    }
}
