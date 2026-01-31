<?php

namespace App\Livewire\CategoriaPersonal;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\CategoriaPersonal;
use Livewire\WithPagination;

#[Title('Categorías de Personal')]
class CategoriaPersonalComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $cant = 5;
    public $totalRegistros = 0;

    public $Id;
    public $nombre;

    public function mount()
    {
        $this->totalRegistros = CategoriaPersonal::count();
    }

    public function render()
    {
        if ($this->search != '') {
            $this->resetPage();
        }

        $this->totalRegistros = CategoriaPersonal::count();

        $categorias = CategoriaPersonal::where('nombre','like','%'.$this->search.'%')
            ->orderBy('id','desc')
            ->paginate($this->cant);

        return view('livewire.categoria-personal.categoria-personal-component',[
            'categorias' => $categorias
        ]);
    }

    public function create()
    {
        $this->Id = 0;
        $this->reset(['nombre']);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalCategoriaPersonal');
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|min:3|max:255|unique:categoria_personals'
        ]);

        CategoriaPersonal::create(['nombre'=>$this->nombre]);

        $this->dispatch('close-modal','modalCategoriaPersonal');
        $this->dispatch('msg','Categoría creada exitosamente');
    }

    public function edit(CategoriaPersonal $categoria)
    {
        $this->Id = $categoria->id;
        $this->nombre = $categoria->nombre;
        $this->dispatch('open-modal','modalCategoriaPersonal');
    }

    public function update(CategoriaPersonal $categoria)
    {
        $this->validate([
            'nombre' => 'required|min:3|max:255|unique:categoria_personals,nombre,'.$this->Id
        ]);

        $categoria->update(['nombre'=>$this->nombre]);

        $this->dispatch('close-modal','modalCategoriaPersonal');
        $this->dispatch('msg','Categoría editada exitosamente');
    }

    #[On('destroyCategoriaPersonal')]
    public function destroyCategoriaPersonal($id)
    {
        $categoria = CategoriaPersonal::findOrFail($id);
        $categoria->delete();
        $this->dispatch('msg','Categoría eliminada exitosamente');
    }
}

