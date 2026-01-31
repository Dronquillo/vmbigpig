<?php

namespace App\Livewire\Farms;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\lots as Lot;
use App\Models\barns as Barn;

#[Title('Lotes')]

class LotComponent extends Component
{

    public $lots, $barns;
    public $code, $barn_id, $initial_count, $current_count, $start_date;
    public $Id = 0;

    public function mount()
    {
        $this->lots = Lot::with('barn')->paginate(10);
        $this->barns = Barn::all();
    }

    public function create() { $this->resetForm(); $this->dispatch('openLotModal'); }

    public function store()
    {
        $this->validate([
            'code'=>'required|unique:lots,code',
            'barn_id'=>'required|exists:barns,id',
            'initial_count'=>'required|integer|min:1',
            'start_date'=>'required|date',
        ]);
        Lot::create([
            'code'=>$this->code,
            'barn_id'=>$this->barn_id,
            'initial_count'=>$this->initial_count,
            'current_count'=>$this->initial_count,
            'start_date'=>$this->start_date,
        ]);
        $this->resetForm();
    }

    public function resetForm(){ $this->Id=0; $this->code=''; $this->barn_id=''; $this->initial_count=''; $this->current_count=''; $this->start_date=''; }

    public function render()
    {
        return view('livewire.farms.lot-component',
        ['lots'=>$this->lots,'barns'=>$this->barns]);
    }

}

