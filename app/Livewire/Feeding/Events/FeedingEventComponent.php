<?php

namespace App\Livewire\Feeding\Events;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\feeding_events as FeedingEvent;
use App\Models\lots as Lot;
use App\Models\Activovivo as Pig; 

#[Title('Eventos de Alimentación')]
class FeedingEventComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $totalRegistros = 0;
    public $cant = 10;

    public $Id;
    public $date;
    public $lot_id;
    public $pig_id;
    public $ration_target_kg;
    public $ration_actual_kg;
    public $waste_kg;
    public $cost_usd;
    public $composition;

    public function mount()
    {
        $this->totalRegistros = FeedingEvent::count();
    }

    public function render()
    {
        if ($this->search != '') $this->resetPage();

        $this->totalRegistros = FeedingEvent::count();

        $events = FeedingEvent::with(['lot','pig'])
            ->orderBy('date','desc')
            ->paginate($this->cant);

        $lots = Lot::orderBy('code')->get();
        $pigs = Pig::orderBy('codigo')->get();

        return view('livewire.feeding.events.events', compact('events','lots','pigs'));
    }

    public function create()
    {
        $this->Id = 0;
        $this->reset([
            'date','lot_id','pig_id',
            'ration_target_kg','ration_actual_kg',
            'waste_kg','cost_usd','composition'
        ]);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalFeeding');
    }

    public function store()
    {
        $data = $this->validate([
            'date' => 'required|date',
            'lot_id' => 'nullable|exists:lots,id',
            'pig_id' => 'nullable|exists:activovivos,id',
            'ration_target_kg' => 'nullable|numeric|min:0',
            'ration_actual_kg' => 'required|numeric|min:0.1',
            'waste_kg' => 'nullable|numeric|min:0',
            'cost_usd' => 'nullable|numeric|min:0',
            'composition' => 'nullable|string',
        ]);

        FeedingEvent::create($data);

        $this->totalRegistros = FeedingEvent::count();
        $this->dispatch('close-modal','modalFeeding');
        $this->dispatch('msg','Evento registrado exitosamente');
    }

    public function edit(FeedingEvent $event)
    {
        $this->Id = $event->id;
        $this->date = $event->date->format('Y-m-d');
        $this->lot_id = $event->lot_id;
        $this->pig_id = $event->pig_id;
        $this->ration_target_kg = $event->ration_target_kg;
        $this->ration_actual_kg = $event->ration_actual_kg;
        $this->waste_kg = $event->waste_kg;
        $this->cost_usd = $event->cost_usd;
        $this->composition = is_array($event->composition) 
            ? implode(',', $event->composition) 
            : $event->composition;

        $this->dispatch('open-modal','modalFeeding');
    }

    public function update(FeedingEvent $event)
    {
        $data = $this->validate([
            'date' => 'required|date',
            'lot_id' => 'nullable|exists:lots,id',
            'pig_id' => 'nullable|exists:activovivos,id',
            'ration_target_kg' => 'nullable|numeric|min:0',
            'ration_actual_kg' => 'required|numeric|min:0.1',
            'waste_kg' => 'nullable|numeric|min:0',
            'cost_usd' => 'nullable|numeric|min:0',
            'composition' => 'nullable|string',
        ]);

        $event->update($data);

        $this->dispatch('close-modal','modalFeeding');
        $this->dispatch('msg','Evento actualizado exitosamente');
    }

}
