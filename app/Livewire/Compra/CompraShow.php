<?php

namespace App\Livewire\Compra;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Compra;


#[Title('Ver Compra')]
class CompraShow extends Component
{

    public $id;
    public $compra;

    public function mount(Compra $compra)
    {
        //$this->compra = $compra;
        $this->compra = $compra->load(['proveedor','empresa','detalles.producto'])->findOrFail($this->id);
    }    

    public function render()
    {
        // Cargar compra con sus detalles y producto relacionado
        //$compra = Compra::with(['proveedor','empresa','detalles.producto'])->findOrFail($this->id);

        return view('livewire.compra.compra-show', [
            'compra' => $this->compra,
            'compraDetalle' => $this->compra->detalles,
        ]);

    }

}
