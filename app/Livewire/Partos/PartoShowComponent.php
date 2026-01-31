<?php

namespace App\Livewire\Partos;

use Livewire\Component;
use App\Models\TablaPartos;
use Livewire\Attributes\Title;

#[Title('Partos')]
class PartoShowComponent extends Component
{
    public $parto;

    public function mount($id)
    {
        // Cargar el parto con sus relaciones
        $this->parto = TablaPartos::with(['estados','activo','personal'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.partos.show', [
            'parto' => $this->parto,
        ]);
    }
}
