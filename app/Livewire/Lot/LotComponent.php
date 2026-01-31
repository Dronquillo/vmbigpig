<?php

namespace App\Livewire\Lot;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\lots as Lot;
use App\Models\Barns as Barn;
use App\Models\Activovivo;
use Illuminate\Support\Facades\DB;

#[Title('Gestión de Lotes')]
class LotComponent extends Component
{
    use WithPagination;

    // Listado
    public $search = '';
    public $perPage = 10;
    public $totalRegistros = 0;

    // Form
    public $Id = 0;
    public $barn_id, $code, $start_date, $end_date = null;
    public $initial_count = 0, $current_count = 0;

    // Aux
    public $barns = [];
    public $availablePigs = []; // cerdos sin lote
    public $lotPigs = [];       // cerdos en el lote
    public $selectedPigs = [];  // ids seleccionados para asignar
    public $selectedLotPigIds = []; // ids seleccionados para remover

    public function mount()
    {
        $this->barns = Barn::orderBy('id')->get();
    }

    public function render()
    {
        if ($this->search !== '') $this->resetPage();

        $query = Lot::with('barn')->orderByDesc('id');
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('code', 'like', "%{$this->search}%")
                  ->orWhereHas('barn', fn($b) => $b->where('name', 'like', "%{$this->search}%"));
            });
        }
        $lots = $query->paginate($this->perPage);
        $this->totalRegistros = $lots->total();

        return view('livewire.lot.lot-component', [
            'lots' => $lots,
        ]);
    }

    // Open modal
    public function create()
    {
        $this->resetForm();
        $this->dispatch('open-modal', 'modalLot');
        $this->loadPigPickers(); // cargar listas iniciales
    }

    public function edit($id)
    {
        $lot = Lot::findOrFail($id);

        $this->Id            = $lot->id;
        $this->barn_id       = $lot->barn_id;
        $this->code          = $lot->code;
        $this->start_date    = optional($lot->start_date)->format('Y-m-d');
        $this->end_date      = optional($lot->end_date)?->format('Y-m-d');
        $this->initial_count = $lot->initial_count;
        $this->current_count = $lot->current_count;

        $this->dispatch('open-modal', 'modalLot');
        $this->loadPigPickers($lot->id);
    }

    public function resetForm()
    {
        $this->reset([
            'Id', 'barn_id', 'code', 'start_date', 'end_date',
            'initial_count', 'current_count',
            'availablePigs', 'lotPigs', 'selectedPigs', 'selectedLotPigIds',
        ]);
        $this->resetErrorBag();
    }

    protected function rules()
    {
        return [
            'barn_id' => 'required|exists:barns,id',
            'code' => 'required|string|max:50|unique:lots,code,' . ($this->Id ?: 'NULL') . ',id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'initial_count' => 'required|integer|min:0',
        ];
    }

    protected function messages()
    {
        return [
            'barn_id.required' => 'La bodega/galpón es requerido.',
            'code.required' => 'El código del lote es requerido.',
            'code.unique' => 'El código del lote ya existe.',
            'start_date.required' => 'La fecha de inicio es requerida.',
            'end_date.after_or_equal' => 'La fecha de cierre debe ser posterior al inicio.',
            'initial_count.min' => 'El conteo inicial no puede ser negativo.',
        ];
    }

    public function store()
    {
        $this->validate();

        $lot = Lot::create([
            'barn_id' => $this->barn_id,
            'code' => $this->code,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'initial_count' => $this->initial_count,
            'current_count' => 0,
        ]);

        // si se seleccionaron cerdos antes de guardar (UI dinámica)
        if (!empty($this->selectedPigs)) {
            $this->assignPigsToLot($lot->id, $this->selectedPigs);
        }

        $this->syncCurrentCount($lot->id);

        $this->dispatch('close-modal', 'modalLot');
        $this->dispatch('msg', 'Lote creado exitosamente');
        $this->resetForm();
    }

    public function update($id)
    {
        $this->validate();

        $lot = Lot::findOrFail($id);
        $lot->update([
            'barn_id' => $this->barn_id,
            'code' => $this->code,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'initial_count' => $this->initial_count,
        ]);

        $this->syncCurrentCount($lot->id);

        $this->dispatch('close-modal', 'modalLot');
        $this->dispatch('msg', 'Lote editado exitosamente');
        $this->resetForm();
    }

    // Pickers
    public function loadPigPickers($lotId = null)
    {
        // disponibles = sin lote y estado activo
        $this->availablePigs = Activovivo::whereNull('lot_id')
            ->where('estado', 'activo')
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();

        if ($lotId) {
            $this->lotPigs = Activovivo::where('lot_id', $lotId)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $this->lotPigs = collect();
        }
    }

    // Assign and remove
    public function assignSelectedPigs()
    {
        if ($this->Id == 0) return; // solo con lote existente
        $this->assignPigsToLot($this->Id, $this->selectedPigs);
        $this->loadPigPickers($this->Id);
        $this->syncCurrentCount($this->Id);
        $this->dispatch('msg', 'Cerdos asignados al lote');
        $this->selectedPigs = [];
    }

    private function assignPigsToLot($lotId, array $pigIds)
    {
        if (empty($pigIds)) return;

        DB::transaction(function () use ($lotId, $pigIds) {
            Activovivo::whereIn('id', $pigIds)
                ->whereNull('lot_id')
                ->update(['lot_id' => $lotId]);
        });
    }

    public function removeSelectedLotPigs()
    {
        if ($this->Id == 0) return;

        DB::transaction(function () {
            Activovivo::whereIn('id', $this->selectedLotPigIds)
                ->where('lot_id', $this->Id)
                ->update(['lot_id' => null]);
        });

        $this->loadPigPickers($this->Id);
        $this->syncCurrentCount($this->Id);
        $this->dispatch('msg', 'Cerdos removidos del lote');
        $this->selectedLotPigIds = [];
    }

    // sync count
    private function syncCurrentCount($lotId)
    {
        $count = Activovivo::where('lot_id', $lotId)->count();
        Lot::where('id', $lotId)->update(['current_count' => $count]);
        $this->current_count = $count;
    }

    // Close lot
    public function closeLot($id)
    {
        $lot = Lot::findOrFail($id);
        $lot->update(['end_date' => now()->toDateString()]);
        $this->dispatch('msg', 'Lote cerrado');
    }
}
