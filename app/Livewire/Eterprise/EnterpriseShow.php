<?php

namespace App\Livewire\Eterprise;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Empresa as Enterprise;

#[Title('Ver Categoria')]

class EnterpriseShow extends Component
{

    public Enterprise $enterprise;
    
    public function render()
    {
        return view('livewire.eterprise.enterprise-show');
    }
}
