<?php

namespace App\Livewire\Farms;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Activovivo as Cerdos;


#[Title('Ver Activos Vivos')]
class FarmsShow extends Component
{

    public Cerdos $cerdos;
    
    public function render()
    {
        return view('livewire.farms.farms-show');
    }
}
