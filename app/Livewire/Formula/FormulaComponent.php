<?php

namespace App\Livewire\Formula;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\FeedFormula;
use App\Models\FeedFormulaItem;
use App\Models\Producto;
use App\Models\TablaMedida as Measurement;

#[Title('Fórmulas de Alimentación')]
class FormulaComponent extends Component
{
    public $Id = 0;
    public $name, $notes;
    public $items = [];
    public $productos = [];

    public function mount()
    {

        $this->productos = Producto::all();
        $this->items = [['producto_id' => null, 'percentage' => 0, 'cantidad' => 0, 'medida_id' => null]];

    }

    public function render()
    {
        $productos = Producto::all();
        $medidas = Measurement::all();
        $formulas = FeedFormula::with('items.producto')->orderBy('id','desc')->paginate(10);

        return view('livewire.feeding.formulas.formulas', compact('formulas','productos','medidas'));
        
    }

    public function addItem()
    {
        $this->items[] = ['producto_id' => null, 'percentage' => 0, 'cantidad' => 0, 'medida_id' => null];


    }

    public function crear()
    {
        $this->Id = 0;
        $this->reset(['name','notes','items']);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalFormula');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3|max:255|unique:feed_formulas',
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|numeric|min:0',
            'items.*.medida_id' => 'required|exists:tabla_medidas,id',
            'items.*.percentage' => 'required|numeric|min:0|max:100',
        ]);

        $formula = FeedFormula::create(['name'=>$this->name,'notes'=>$this->notes]);

        foreach ($this->items as $item) {
            FeedFormulaItem::create([
                'feed_formula_id'=>$formula->id,
                'producto_id'=>$item['producto_id'],
                'cantidad'=>$item['cantidad'],
                'medida_id'=>$item['medida_id'],
                'percentage'=>$item['percentage'],
            ]);
        }

        $this->resetForm();
        $this->dispatch('close-modal','modalFormula');
        $this->dispatch('msg','Fórmula creada exitosamente');
    }

    public function edit(FeedFormula $formula)
    {
        $this->Id = $formula->id;
        $this->name = $formula->name;
        $this->notes = $formula->notes;
        $this->items = $formula->items->map(fn($i)=>[
            'producto_id'=>$i->producto_id,
            'cantidad'=>$i->cantidad,
            'medida_id'=>$i->medida_id,
            'percentage'=>$i->percentage
        ])->toArray();

        $this->dispatch('open-modal','modalFormula');
    }

    public function update(FeedFormula $formula)
    {
        $this->validate([
            'name' => 'required|min:3|max:255|unique:feed_formulas,name,'.$this->Id,
            'items.*.producto_id' => 'required|exists:productos,id',
            'items.*.cantidad' => 'required|numeric|min:0',
            'items.*.medida_id' => 'required|exists:tabla_medidas,id',
            'items.*.percentage' => 'required|numeric|min:0|max:100',
        ]);

        $formula->update(['name'=>$this->name,'notes'=>$this->notes]);
        $formula->items()->delete();

        foreach ($this->items as $item) {
            FeedFormulaItem::create([
                'feed_formula_id'=>$formula->id,
                'producto_id'=>$item['producto_id'],
                'cantidad'=>$item['cantidad'],
                'medida_id'=>$item['medida_id'],
                'percentage'=>$item['percentage'],
            ]);
        }

        $this->resetForm();
        $this->dispatch('close-modal','modalFormula');
        $this->dispatch('msg','Fórmula actualizada exitosamente');
    }

    public function destroy($id)
    {
        FeedFormula::findOrFail($id)->delete();
        $this->dispatch('msg','Fórmula eliminada exitosamente');
    }

    private function resetForm()
    {
        $this->Id = 0;
        $this->name = '';
        $this->notes = '';
        $this->items = [['producto_id'=>null,'percentage'=>0,'cantidad'=>0,'medida_id'=>null]];
    }
}
