<?php

namespace App\Livewire\Personal;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\Personal;
use App\Models\CategoriaPersonal;
use Livewire\WithPagination;

#[Title('Personal')]
class PersonalComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $cant = 5;
    public $totalRegistros = 0;

    // propiedades modelo
    public $Id;
    public $nombre, $apellido, $email, $telefono, $fecha_ingreso, $fecha_salida, $estado = 'activo', $cargo_id;

    public function mount()
    {
        $this->totalRegistros = Personal::count();
    }

    public function render()
    {
        if ($this->search != '') {
            $this->resetPage();
        }

        $this->totalRegistros = Personal::count();

        $personals = Personal::with('categoria')
            ->where(function($q){
                $q->where('nombre','like','%'.$this->search.'%')
                  ->orWhere('apellido','like','%'.$this->search.'%')
                  ->orWhere('email','like','%'.$this->search.'%');
            })
            ->orderBy('id','desc')
            ->paginate($this->cant);

        $categorias = CategoriaPersonal::all();

        return view('livewire.personal.personal-component',[
            'personals' => $personals,
            'categorias' => $categorias
        ]);
    }

    public function create()
    {
        $this->Id = 0;
        $this->reset(['nombre','apellido','email','telefono','fecha_ingreso','fecha_salida','estado','cargo_id']);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalPersonal');
    }

    public function store()
    {
        $rules = [
            'nombre' => 'required|min:3|max:255',
            'apellido' => 'required|min:3|max:255',
            'email' => 'required|email|unique:personals',
            'cargo_id' => 'required|exists:categoria_personals,id',
        ];

        $this->validate($rules);

        Personal::create([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'fecha_ingreso' => $this->fecha_ingreso,
            'fecha_salida' => $this->fecha_salida,
            'estado' => $this->estado,
            'cargo_id' => $this->cargo_id,
        ]);

        $this->dispatch('close-modal','modalPersonal');
        $this->dispatch('msg','Personal creado exitosamente');
    }

    public function edit(Personal $personal)
    {
        $this->Id = $personal->id;
        $this->fill($personal->toArray());
        $this->dispatch('open-modal','modalPersonal');
    }

    public function update(Personal $personal)
    {
        $rules = [
            'nombre' => 'required|min:3|max:255',
            'apellido' => 'required|min:3|max:255',
            'email' => 'required|email|unique:personals,email,'.$this->Id,
            'cargo_id' => 'required|exists:categoria_personals,id',
        ];

        $this->validate($rules);

        $personal->update($this->only([
            'nombre','apellido','email','telefono','fecha_ingreso','fecha_salida','estado','cargo_id'
        ]));

        $this->dispatch('close-modal','modalPersonal');
        $this->dispatch('msg','Personal editado exitosamente');
    }

    #[On('destroyPersonal')]
    public function destroyPersonal($id)
    {
        $personal = Personal::findOrFail($id);
        $personal->delete();
        $this->dispatch('msg','Personal eliminado exitosamente');
    }
}
