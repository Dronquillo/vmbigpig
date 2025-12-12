<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


#[Title('Usuarios')]

class UserComponent extends Component
{

    use WithPagination;
    use WithFileUploads;

    //propiedades clase
    public $search = '';
    public $totalRegistros = 0;
    public $cant=5;    

    //propiedades modelo
    public $name;
    public $Id;
    public $email;
    public $password;
    public $admin = true;
    public $activo = true;
    public $image;
    public $imageModel;
    public $re_password;

    public function render()
    {

        if( $this->search !='' ){
            $this->resetPage();
        }

        $this->totalRegistros = User::count();

        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id','desc')
            ->paginate($this->cant);

        return view('livewire.user.user-component',[
            'users' => $users
        ]);

    }

    public function create(){

        $this->Id=0;

        $this->limpiar();

        $this->dispatch('open-modal','modalUser');

    }

    public function store()
    {
        $rules = [
            'name' => 'required|min:5|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:5',
            're_password' => 'required|same:password',
            'image' => 'nullable|image|max:1024', // 1MB Max
        ];

        $this->validate($rules);

        //crear usuario
        $user = new User();

        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);
        $user->admin = $this->admin;
        $user->activo = $this->activo;
        $user->save();

        if($this->image){
            $customName = 'users/'.uniqid().'.'.$this->image->extension();
            $this->image->storeAs('public', $customName);
            $user->image()->create(['url' => $customName]);
        }

        //actualizar total registros
        $this->totalRegistros = User::count();
        
        //cerrar modal via browser event
        $this->dispatch('close-modal','modalUser');
        $this->dispatch('msg','Usuario creado exitosamente');
        $this->limpiar();

    }   

    public function edit(User $user)
    {
        $this->Id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->admin = $user->admin ? true : false;
        $this->activo = $user->activo ? true : false;
        $this->imageModel = $user->image ? $user->image->url : null;

        $this->dispatch('open-modal','modalUser');

    }

    public function update(User $user)
    {
        $rules = [
            'nombre' => 'required|min:5|max:255',
            'email' => 'required|email|max:255|unique:users,id,'.$this->Id,
            'password' => 'required|min:5',
            're_password' => 'required|same:password',
            'image' => 'nullable|image|max:1024', // 1MB Max            
        ];

        $this->validate($rules);

        //actualizar usuario
        $user->name = $this->name;
        $user->email = $this->email;
        $user->admin = $this->admin;
        $user->activo = $this->activo;

        if($this->password != null){
            $user->password = bcrypt($this->password);
        }

        $user->update();

        if($this->image){
            if($user->image!=null){
                Storage::delete('public/'.$user->image->url);
                $user->image()->delete();
            }

            $customName = 'users/'.uniqid().'.'.$this->image->extension();
            $this->image->storeAs('public', $customName);
            $user->image()->create(['url' => $customName]);

        }
        //cerrar modal via browser event
        $this->dispatch('close-modal','modalUser');
        $this->dispatch('msg','Usuario actualizado exitosamente');
        $this->limpiar();

    }    

    #[On('destroyUser')]
    public function destroy($id){
        $user = User::findOrfail($id);
        if($user->image!=null){
            Storage::delete('public/'.$user->image->url);
            $user->image()->delete();
        }

        $user->delete();

        $this->dispatch('msg', 'Usuario eliminado correctamente');

    }

    public function limpiar(){

        $this->reset(['Id', 'name', 'email', 'password', 're_password', 'admin', 'activo', 'image', 'imageModel']);
        $this->resetErrorBag();

    }
    
    



}
