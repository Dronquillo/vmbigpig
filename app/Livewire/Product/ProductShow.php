<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Producto as Product;

#[Title('Ver Producto')]
class ProductShow extends Component
{

    public Product $product;

    public function render()
    {

        return view('livewire.product.product-show');
        
    }
}
