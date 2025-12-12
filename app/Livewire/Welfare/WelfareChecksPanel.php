<?php

namespace App\Livewire\Welfare;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\welfare_checks as WelfareCheck;
use App\Models\lots as Lot;

#[Title('Controles de Bienestar Animal')]
class WelfareChecksPanel extends Component
{

    public $lotId;
    public $date, $condition, $severity = 'low', $notes, $vet_required = false;

    public function save(){
        $this->validate([
            'lotId' => 'required|exists:lots,id',
            'date' => 'required|date',
            'condition' => 'required|string|max:120',
            'severity' => 'required|in:low,medium,high',
        ]);
        WelfareCheck::create([
            'lot_id'=>$this->lotId,
            'date'=>$this->date,
            'condition'=>$this->condition,
            'severity'=>$this->severity,
            'notes'=>$this->notes,
            'vet_required'=>$this->vet_required,
        ]);
        $this->reset(['date','condition','severity','notes','vet_required']);
        $this->dispatch('welfare-saved');
    }

    public function render()
    {
        return view('livewire.welfare.welfare-checks-panel', [
            'lots' => Lot::active()->get(),
            'checks' => WelfareCheck::where('lot_id',$this->lotId)->latest()->take(50)->get(),
        ]);
    }
}
