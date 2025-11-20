<?php

namespace App\Livewire\Measurement;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\TablaMedida as Measurement;

#[Title('Ver Medidas')]

class MeasurementShow extends Component
{
    public Measurement $measurement;

    public function render()
    {
        return view('livewire.measurement.measurement-show');

    }
}
