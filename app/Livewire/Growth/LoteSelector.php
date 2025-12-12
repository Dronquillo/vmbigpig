<?php

namespace App\Livewire\Growth;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\lots as Lot;

#[Title('Alimentacion de lotes')]

class LoteSelector extends Component
{

    public $lots;
    public $totalRegistros;

    public function mount()
    {
        $this->lots = Lot::active()->with('barn')->paginate(10);
        $this->totalRegistros = $this->lots->total();
    }

    public function render()
    {
        return view('livewire.growth.lote-selector', [
            'lots' => $this->lots
        ]);
    }


}
