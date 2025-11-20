<?php

namespace App\Livewire\Providers;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Proveedor as Provider;


#[Title('Ver Proveedores')]
class ProvidersShow extends Component
{

    public Provider $provider;
    
    public function render()
    {
        return view('livewire.providers.providers-show');
    }

}
