<?php

namespace App\Livewire\Feeding;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\feed_items as FeedItem;

#[Title('Administrador de Inventario de Alimento')]

class FeedInventoryManager extends Component
{

     public $items;
    public $name, $cost_per_unit, $stock;

    public function mount(){ $this->items = FeedItem::orderBy('name')->get(); }

    public function create(){
        $this->validate([
            'name' => 'required|string|max:120',
            'cost_per_unit' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
        ]);
        FeedItem::create([
            'name'=>$this->name,
            'cost_per_unit'=>$this->cost_per_unit,
            'stock'=>$this->stock,
        ]);
        $this->reset(['name','cost_per_unit','stock']);
        $this->items = FeedItem::orderBy('name')->get();
    }

    public function updateStock($id, $stock){
        $item = FeedItem::find($id);
        if (!$item) return;
        $item->update(['stock'=>$stock]);
        $this->items = FeedItem::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.feeding.feed-inventory-manager');
    }
}
