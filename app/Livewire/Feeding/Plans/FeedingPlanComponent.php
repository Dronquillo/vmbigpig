<?php

namespace App\Livewire\Feeding\Plans;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\feeding_plans as FeedingPlan;
use App\Models\lots as Lot;
use App\Models\FeedFormula;


#[Title('Planes de Alimentación')]
class FeedingPlanComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $totalRegistros = 0;
    public $cant = 10;

    public $Id;
    public $lot_id;
    public $formula_id;
    public $day_from;
    public $day_to;
    public $ration_per_pig_kg;

    public function mount()
    {
        $this->totalRegistros = FeedingPlan::count();
    }

    public function render()
    {
        if ($this->search != '') $this->resetPage();

        $this->totalRegistros = FeedingPlan::count();

        $plans = FeedingPlan::with(['lot','formula'])
            ->orderBy('id','desc')
            ->paginate($this->cant);

        $lots = Lot::orderBy('code')->get();
        $formulas = FeedFormula::orderBy('name')->get();
 
        return view('livewire.feeding.plans.plans', compact('plans','lots','formulas'));

    }

    public function create()
    {
        $this->Id = 0;
        $this->reset(['lot_id','formula_id','day_from','day_to','ration_per_pig_kg']);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalPlan');
    }

    public function store()
    {

        $data = $this->validate([
            'lot_id' => 'required|exists:lots,id',
            'formula_id' => 'required|exists:feed_formulas,id',
            'day_from' => 'required|integer|min:0',
            'day_to' => 'required|integer|min:0|gte:day_from',
            'ration_per_pig_kg' => 'required|numeric',
        ]);

        FeedingPlan::create($data);

        $this->totalRegistros = FeedingPlan::count();
        $this->dispatch('close-modal','modalPlan');
        $this->dispatch('msg','Plan creado exitosamente');

    }

    public function edit(FeedingPlan $plan)
    {
        $this->Id = $plan->id;
        $this->lot_id = $plan->lot_id;
        $this->formula_id = $plan->formula_id;
        $this->day_from = $plan->day_from;
        $this->day_to = $plan->day_to;
        $this->ration_per_pig_kg = $plan->ration_per_pig_kg;
        $this->dispatch('open-modal','modalPlan');
    }

    public function update(FeedingPlan $plan)
    {
        $data = $this->validate([
            'lot_id' => 'required|exists:lots,id',
            'formula_id' => 'required|exists:feed_formulas,id',
            'day_from' => 'required|integer|min:0',
            'day_to' => 'required|integer|min:0|gte:day_from',
            'ration_per_pig_kg' => 'required|numeric|min:0',
        ]);

        $plan->update($data);

        $this->dispatch('close-modal','modalPlan');
        $this->dispatch('msg','Plan actualizado exitosamente');
    }

    public function destroy(FeedingPlan $plan)
    {
        $plan->delete();
        $this->dispatch('msg','Plan eliminado');
    }

}
