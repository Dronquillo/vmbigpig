<?php

namespace App\Livewire\Growth\Weights;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\weight_records as WeightRecord;
use App\Models\lots as Lot;
use App\Models\Activovivo as Pig;

#[Title('Registros de Peso')]
class WeightRecordComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $totalRegistros = 0;
    public $cant = 10;

    public $Id;
    public $date;
    public $lot_id;
    public $pig_id;
    public $weight_kg;

    public function mount()
    {
        $this->totalRegistros = WeightRecord::count();
    }

    public function render()
    {

        if ($this->search !== '') $this->resetPage();

        $this->totalRegistros = WeightRecord::count();

        $records = WeightRecord::with(['lot','pig'])
            ->orderBy('date','desc')
            ->paginate($this->cant);

        $lots = Lot::orderBy('code')->get();
        $pigs = Pig::All();

        return view('livewire.growth.weights.weights', compact('records','lots','pigs'));
    }

    public function create()
    {
        $this->Id = 0;
        $this->reset(['date','lot_id','pig_id','weight_kg']);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalWeight');
    }

    public function store()
    {
        $data = $this->validate([
            'date' => 'required|date',
            'lot_id' => 'nullable|exists:lots,id',
            'pig_id' => 'nullable|exists:activovivos,id',
            'weight_kg' => 'required|numeric|min:0.1',
        ]);

        WeightRecord::create($data);

        $this->totalRegistros = WeightRecord::count();
        $this->dispatch('close-modal','modalWeight');
        $this->dispatch('msg','Peso registrado exitosamente');
    }

    public function edit(WeightRecord $record)
    {
        $this->Id = $record->id;
        $this->date = $record->date->format('Y-m-d');
        $this->lot_id = $record->lot_id;
        $this->pig_id = $record->pig_id;
        $this->weight_kg = $record->weight_kg;

        $this->dispatch('open-modal','modalWeight');
    }

    public function update(WeightRecord $record)
    {
        $data = $this->validate([
            'date' => 'required|date',
            'lot_id' => 'nullable|exists:lots,id',
            'pig_id' => 'nullable|exists:activovivos,id',
            'weight_kg' => 'required|numeric|min:0.1',
        ]);

        $record->update($data);

        $this->dispatch('close-modal','modalWeight');
        $this->dispatch('msg','Registro de peso actualizado exitosamente');
    }

    public function destroy(WeightRecord $record)
    {
        $record->delete();
        $this->dispatch('msg','Registro de peso eliminado');
    }
}
