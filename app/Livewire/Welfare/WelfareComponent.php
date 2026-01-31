<?php

namespace App\Livewire\Welfare;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\welfare_checks as WelfareCheck;
use App\Models\lots as Lot;
use App\Models\Activovivo as Pig;

#[Title('Chequeos de Bienestar')]
class WelfareComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $totalRegistros = 0;
    public $cant = 10;

    public $Id;
    public $date;
    public $lot_id;
    public $pig_id;
    public $condition;
    public $severity;
    public $notes;
    public $vet_required = false;

    public function mount()
    {
        $this->totalRegistros = WelfareCheck::count();
    }

    public function render()
    {
        if ($this->search !== '') $this->resetPage();

        $this->totalRegistros = WelfareCheck::count();

        $checks = WelfareCheck::with(['lot','pig'])
            ->orderBy('date','desc')
            ->paginate($this->cant);

        $lots = Lot::orderBy('code')->get();
        $pigs = Pig::All();

        return view('livewire.welfare.welfare', compact('checks','lots','pigs'));
    }

    public function create()
    {
        $this->Id = 0;
        $this->reset(['date','lot_id','pig_id','condition','severity','notes']);
        $this->vet_required = false;
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalWelfare');
    }

    public function store()
    {
        $data = $this->validate([
            'lot_id' => 'nullable|exists:lots,id',
            'pig_id' => 'nullable|exists:activovivos,id',
            'date' => 'required|date',
            'condition' => 'required|string|max:100',
            'severity' => 'required|in:low,medium,high',
            'notes' => 'nullable|string',
            'vet_required' => 'boolean',
        ]);

        WelfareCheck::create($data);

        $this->totalRegistros = WelfareCheck::count();
        $this->dispatch('close-modal','modalWelfare');
        $this->dispatch('msg','Chequeo registrado exitosamente');
    }

    public function edit(WelfareCheck $check)
    {
        $this->Id = $check->id;
        $this->date = $check->date;
        $this->lot_id = $check->lot_id;
        $this->pig_id = $check->pig_id;
        $this->condition = $check->condition;
        $this->severity = $check->severity;
        $this->notes = $check->notes;
        $this->vet_required = (bool) $check->vet_required;

        $this->dispatch('open-modal','modalWelfare');
    }

    public function update(WelfareCheck $check)
    {
        $data = $this->validate([
            'lot_id' => 'nullable|exists:lots,id',
            'pig_id' => 'nullable|exists:activovivos,id',
            'date' => 'required|date',
            'condition' => 'required|string|max:100',
            'severity' => 'required|in:low,medium,high',
            'notes' => 'nullable|string',
            'vet_required' => 'boolean',
        ]);

        $check->update($data);

        $this->dispatch('close-modal','modalWelfare');
        $this->dispatch('msg','Chequeo actualizado exitosamente');
    }

    public function destroy(WelfareCheck $check)
    {
        $check->delete();
        $this->dispatch('msg','Chequeo eliminado');
    }
    
}
