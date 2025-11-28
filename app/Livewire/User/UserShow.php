<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Usuario Detalle')]

class UserShow extends Component
{
    public User $user;

    public function render()
    {
        
        return view('livewire.user.user-show');

    }

}
