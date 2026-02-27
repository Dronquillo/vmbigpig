<?php

namespace App\Livewire\Control;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Control;


#[Title('Ver Registro de Control')]
class ControlShow extends Component
{

    public $id;
    public $control;

    public function mount(Control $control)
    {
        //$this->control = $control;
        $this->control = $control->load(['empresa','detalles.producto'])->findOrFail($this->id);
    }    

    public function render()
    {
        // Cargar control con sus detalles y producto relacionado
        //$control = Control::with(['empresa','detalles.producto'])->findOrFail($this->id);

        return view('livewire.control.control-detalles', [
            'control' => $this->control,
            'controlDetalle' => $this->control->detalles,
        ]);

    }

}