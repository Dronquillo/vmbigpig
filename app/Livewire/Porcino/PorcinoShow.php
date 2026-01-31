<?php

namespace App\Livewire\Porcino;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Activovivo as Cerdos;


#[Title('Ver Activos Vivos')]
class PorcinoShow extends Component
{

    public Cerdos $cerdos;
    
    public function render()
    {
        return view('livewire.porcino.porcino-show');
    }
}