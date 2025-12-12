<?php

namespace App\Livewire\Feeding;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\lots as Lot;
use App\Models\feeding_plans as FeedingPlan;
use App\Models\feeding_events as FeedingEvent;
use App\Models\ActivoVivo;
use App\Models\Producto;
use App\Services\FeedingCalculator;
use App\Services\InventoryService;

#[Title('Panel de Alimentacion')]
class FeedingDashboard extends Component
{

    public $day = 0;
    public $plan;
    public $targetKg = 0.0;
    public $composition = [];
    public $costTotal = 0.0;
    public $actualKg = 0.0;
    public $wasteKg = 0.0;
    public $lots = [];
    public $costPerKg = 0.0;
    public $pigxKg = 0.0;
    ////


    
    public $selectedLot, $selectedPig, $selectedProduct;
    public $cantidad = 0, $costo = 0;
    public $pigs = [], $products = [], $events = [];

    public function mount()
    {
        $this->lots = Lot::active()->get();
        $this->products = Producto::all();
        $this->events = FeedingEvent::with('lot','pig')->latest()->take(20)->get();

    }

    public function updatedSelectedProduct($id)
    {
        $product = Producto::find($id);
        if ($product && $this->cantidad > 0) {
            $this->costo = $product->precio * $this->cantidad;
        }
    }

    public function updatedCantidad($value)
    {
        $product = Producto::find($this->selectedProduct);
        if ($product) {
            $this->costo = $product->precio * $value;
        }
    }

    public function updatedSelectedLot($id)
    {
        $lot = Lot::find($id);
        if (!$lot) { $this->resetCalc(); return; }

        $this->day = $lot->dayOfCycle();
        $this->plan = FeedingPlan::where('lot_id',$lot->id)
            ->where('day_from','<=',$this->day)->where('day_to','>=',$this->day)->first();

        // cargar cerdos del lote
        $this->pigs = ActivoVivo::where('lot_id',$lot->id)->get();

        if ($this->plan && $this->plan->feedFormula) {
            $calc = FeedingCalculator::targetForLot($lot, $this->plan->feedFormula, (float)$this->plan->ration_per_pig_kg);
            $this->targetKg = $calc['targetKg'];
            $this->composition = $calc['composition'];
            $this->costTotal = $calc['costTotal'];
            $this->actualKg = $this->targetKg;
        } else {
            $this->resetCalc();
        }
    }

    public function save()
    {

        $this->validate([
            'selectedLot' => 'required|exists:lots,id',
            'selectedPig' => 'nullable|exists:activovivos,id',
            'selectedProduct' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.001',
        ]);        

        $product = Producto::find($this->selectedProduct);

        $event = FeedingEvent::create([
            'lot_id' => $this->selectedLot,
            'pig_id' => $this->selectedPig,
            'date' => now()->toDateString(),
            'ration_target_kg' => $this->cantidad,
            'ration_actual_kg' => $this->cantidad,
            'waste_kg' => $this->wasteKg ?? 0,
            'cost_usd' => $this->costo,
            'composition' => json_encode([
                ['producto' => $product->nombre, 'cantidad' => $this->cantidad, 'precio' => $product->precio]
            ]),
        ]);

        // actualizar stock del producto
        $product->decrement('stock', $this->cantidad);
        //$this->events->prepend($event);

        // actualizar inventario
        InventoryService::consume($this->composition);

        // opcional: registrar gasto por cerdo
        foreach ($this->pigs as $pig) {
            $pig->update([
                'peso' => $pig->peso + ($this->actualKg / max(1,$this->pigs->count())) // ejemplo: distribuir alimento
            ]);
        }

        $this->dispatch('feeding-saved', id: $event->id);
        $this->reset(['actualKg','selectedPig','selectedProduct','cantidad','costo','wasteKg']);        

    }

    public function resetCalc()
    {
        $this->day = 0; $this->plan = null; $this->targetKg = 0.0; $this->composition = [];
        $this->costTotal = 0.0; $this->actualKg = 0.0; $this->wasteKg = 0.0; $this->pigs = [];
    }

    public function render()
    {
        return view('livewire.feeding.feeding-dashboard', [
            'lots' => Lot::active()->orderByDesc('id')->get(),
            'pigs' => ActivoVivo::where('lot_id',$this->selectedLot)->get(),
        ]);
    }


}

