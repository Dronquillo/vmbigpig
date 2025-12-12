<?php

namespace App\Livewire\Feeding;

use Livewire\Attributes\Title;

use Livewire\Component;

#[Title('Administrador de Planes de Alimentacion')]

class FeedingPlanManager extends Component
{
    public function render()
    {
        return view('livewire.feeding.feeding-plan-manager');
    }
}
