<?php

namespace App\Livewire\Farms;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\farms as Farm;

#[Title('Gestión de Granjas')]
class FarmComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $totalRegistros = 0;

    public $Id = 0;
    public $name,  $location, $owner, $estado = 'activo';

    public function render()
    {
        if ($this->search !== '') $this->resetPage();

        $query = Farm::orderByDesc('id');
        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%")
                  ->orWhere('location', 'like', "%{$this->search}%");
        }
        $farms = $query->paginate($this->perPage);
        $this->totalRegistros = $farms->total();

        return view('livewire.farms.farm-component', compact('farms'));
    }

    public function create()
    {
        $this->resetForm();
        $this->dispatch('open-modal','modalFarm');
    }

    public function edit($id)
    {
        $farm = Farm::findOrFail($id);
        $this->Id = $farm->id;
        $this->name = $farm->name;
        $this->location = $farm->location;
        $this->owner = $farm->owner;
        $this->estado = $farm->estado;
        $this->dispatch('open-modal','modalFarm');
    }

    public function resetForm()
    {
        $this->reset(['Id','name','location','owner','estado']);
        $this->resetErrorBag();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'location' => 'nullable|string|max:255',
            'owner' => 'nullable|string|max:100',
            'estado' => 'required|string',
        ];
    }

    public function store()
    {
        $this->validate();
        Farm::create($this->only(['name','location','owner','estado']));
        $this->dispatch('close-modal','modalFarm');
        $this->dispatch('msg','Granja creada exitosamente');
        $this->resetForm();
    }

    public function update($id)
    {
        $this->validate();
        $farm = Farm::findOrFail($id);
        $farm->update($this->only(['name','location','owner','estado']));
        $this->dispatch('close-modal','modalFarm');
        $this->dispatch('msg','Granja editada exitosamente');
        $this->resetForm();
    }


}
