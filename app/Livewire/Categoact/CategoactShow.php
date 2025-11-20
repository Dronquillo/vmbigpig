<?php

namespace App\Livewire\Categoact;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\CategoriaActivo as Categoact;

#[Title('Ver Categoria')]

class CategoactShow extends Component
{
    public Categoact $categoact;

    public function render()
    {
        return view('livewire.categoact.categoact-show');
    }
}
