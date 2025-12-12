<?php

namespace App\Livewire\Growth;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\weight_records as WeightRecord;
use App\Services\GrowthMetrics;
use App\Services\AlertService;

#[Title('Alimentacion de lotes')]

class LotWeightsPanel extends Component
{

    public $lotId;
    public $date, $weight_kg;
    public $entries = [];
    public $adg = 0.0, $fcr = 0.0;

    public function mount($lotId){ $this->lotId = $lotId; $this->load(); }

    public function load(){
        $weights = WeightRecord::where('lot_id',$this->lotId)->orderBy('date')->get();
        $this->entries = $weights->toArray();
        $this->adg = GrowthMetrics::adgForLot($this->lotId);
        $this->fcr = GrowthMetrics::fcrForLot($this->lotId);
        AlertService::weightStall($this->lotId, $this->adg);
    }

    public function save(){
        $this->validate([
            'date' => 'required|date',
            'weight_kg' => 'required|numeric|min:0',
        ]);
        WeightRecord::create(['lot_id'=>$this->lotId,'date'=>$this->date,'weight_kg'=>$this->weight_kg]);
        $this->reset(['date','weight_kg']);
        $this->load();
    }


    public function render()
    {
        return view('livewire.growth.lot-weights-panel');
    }
}
