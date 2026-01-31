<?php
// app/Livewire/Barn/BarnComponent.php
namespace App\Livewire\Barn;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\barns as Barn;
use App\Models\farms as Farm;

#[Title('Gestión de Galpones')]
class BarnComponent extends Component
{
    use WithPagination;

    // Listado
    public $search = '';
    public $perPage = 10;
    public $totalRegistros = 0;

    // Form
    public $Id = 0;
    public $farm_id, $name, $type = 'General', $capacity = 0;

    // Aux
    public $farms = [];
    public $types = [];

    public function mount()
    {
        $this->farms = Farm::orderBy('name')->get();
        $this->types = Barn::types();
    }

    public function render()
    {
        if ($this->search !== '') $this->resetPage();

        $query = Barn::with('farm')->orderByDesc('id');
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('type', 'like', "%{$this->search}%")
                  ->orWhereHas('farm', fn($f) => $f->where('name', 'like', "%{$this->search}%"));
            });
        }
        $barns = $query->paginate($this->perPage);
        $this->totalRegistros = $barns->total();

        return view('livewire.barn.barn-component', compact('barns'));
    }

    public function create()
    {
        $this->resetForm();
        $this->dispatch('open-modal', 'modalBarn');
    }

    public function edit($id)
    {
        $barn = Barn::findOrFail($id);
        $this->Id = $barn->id;
        $this->farm_id = $barn->farm_id;
        $this->name = $barn->name;
        $this->type = $barn->type;
        $this->capacity = $barn->capacity;

        $this->dispatch('open-modal', 'modalBarn');
    }

    public function resetForm()
    {
        $this->reset(['Id', 'farm_id', 'name', 'type', 'capacity']);
        $this->resetErrorBag();
    }

    protected function rules()
    {
        return [
            'farm_id' => 'required|exists:farms,id',
            'name' => 'required|string|max:100',
            'type' => 'required|string|in:' . implode(',', Barn::types()),
            'capacity' => 'required|integer|min:0',
        ];
    }

    protected function messages()
    {
        return [
            'farm_id.required' => 'La granja es requerida.',
            'name.required' => 'El nombre del galpón es requerido.',
            'type.in' => 'Tipo de galpón no válido.',
            'capacity.min' => 'La capacidad no puede ser negativa.',
        ];
    }

    public function store()
    {
        $this->validate();

        Barn::create([
            'farm_id' => $this->farm_id,
            'name' => $this->name,
            'type' => $this->type,
            'capacity' => $this->capacity,
        ]);

        $this->dispatch('close-modal', 'modalBarn');
        $this->dispatch('msg', 'Galpón creado exitosamente');
        $this->resetForm();
    }

    public function update($id)
    {
        $this->validate();

        $barn = Barn::findOrFail($id);
        $barn->update([
            'farm_id' => $this->farm_id,
            'name' => $this->name,
            'type' => $this->type,
            'capacity' => $this->capacity,
        ]);

        $this->dispatch('close-modal', 'modalBarn');
        $this->dispatch('msg', 'Galpón editado exitosamente');
        $this->resetForm();
    }

    public function destroyBarn($id)
    {
        $barn = Barn::findOrFail($id);
        // Opcional: validar que no tenga lots activos
        // if ($barn->lots()->active()->exists()) { ... }

        $barn->delete();
        $this->dispatch('msg', 'Galpón eliminado');
    }
}

