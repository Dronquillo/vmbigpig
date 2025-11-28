<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\Producto as Product;
use App\Models\Categoria as Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Title('Productos')]
class ProductComponent extends Component
{

    use WithPagination;
    use WithFileUploads;

    //propiedades clase
    public $search = '';
    public $totalRegistros = 0;
    public $cant=5;
    
    //propiedades modelo
    public $nombre;
    public $Id;
    public $categoria_id;
    public $descripcion;
    public $precio;
    public $costo;
    public $codigo_barras;
    public $stock=10;
    public $stock_minimo;
    public $fecha_vencimiento;
    public $estado='Activo'; 
    public $con_iva=false;
    public $imagen;


    public function render()
    {

        if( $this->search !='' ){
            $this->resetPage();
        }

        $this->totalRegistros = Product::count();

        $categories = Category::All();

        $products = Product::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('id','desc')
            ->paginate($this->cant);

        return view('livewire.product.product-component',[
            'products' => $products,'categories' => $categories
        ]);

    }


    public function create()
    {
        $this->Id = 0;
        
        $this->reset(['nombre']);
        $this->reset(['descripcion']);
        $this->reset(['precio']);
        $this->reset(['costo']);
        $this->reset(['codigo_barras']);
        $this->reset(['stock']);
        $this->reset(['stock_minimo']);
        $this->reset(['fecha_vencimiento']);
        $this->reset(['categoria_id']);
        $this->reset(['con_iva']);
        $this->reset(['estado']);
        $this->reset(['imagen']);
        $this->resetErrorBag();
        
        $this->dispatch('open-modal','modalProduct');
        
    }

    public function store()
    {
        $rules = [
            'nombre' => 'required|min:5|max:255|unique:productos',
            'descripcion' => 'max:250',
            'precio' => 'numeric',
            'costo' => 'required|numeric',
            'codigo_barras' => 'nullable|max:100',
            'stock' => 'required|numeric',
            'stock_minimo' => 'nullable|numeric',
            'categoria_id' => 'required|numeric',  
            'imagen' => 'nullable|image|max:1024',
        ];

        $this->validate($rules);

        if($this->imagen){
            //$imagePath = $this->imagen->store('products','public');
            $customName = 'products/'.uniqid().'.'.$this->imagen->extension();
            $this->imagen->storeAs('public', $customName);
        }

        //crear producto
        $product = new Product();
        $product->nombre = $this->nombre;
        $product->descripcion = $this->descripcion;
        $product->precio = $this->precio;
        $product->costo = $this->costo;
        $product->codigo_barras = $this->codigo_barras;
        $product->stock = $this->stock;
        $product->stock_minimo = $this->stock_minimo;
        $product->fecha_vencimiento = $this->fecha_vencimiento;
        $product->categoria_id = $this->categoria_id;
        $product->con_iva = $this->con_iva;
        $product->estado = $this->estado;
        $product->imagen = $this->imagen;
        $product->save();

        //actualizar total registros
        $this->totalRegistros = Product::count();

        //resetear campo
        $this->nombre = '';
        $this->descripcion = '';
        $this->precio = 0;
        $this->costo = 0;
        $this->codigo_barras = '';
        $this->stock = 0;
        $this->stock_minimo = 0;
        $this->fecha_vencimiento = '';
        $this->categoria_id = 0;
        $this->con_iva = false;
        $this->estado = 'Activo';
        $this->imagen = '';        

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalProduct');
        $this->dispatch('msg','Producto creado exitosamente');

    }    

    public function edit(Product $product)
    {
        $this->Id = $product->id;
        $this->nombre = $product->nombre;
        $this->descripcion = $product->descripcion;
        $this->precio = $product->precio;
        $this->costo = $product->costo;
        $this->codigo_barras = $product->codigo_barras;
        $this->stock = $product->stock;
        $this->stock_minimo = $product->stock_minimo;
        $this->fecha_vencimiento = $product->fecha_vencimiento;
        $this->categoria_id = $product->categoria_id;
        $this->con_iva = $product->con_iva;
        $this->estado = $product->estado;
        $this->imagen = $product->imagen;

        $this->dispatch('open-modal','modalProduct');

    }

    public function update(Product $product)
    {
        $rules = [
            'nombre' => 'required|min:5|max:255|unique:categorias,id,'.$this->Id
        ];

        $this->validate($rules);

        //actualizar categoria
        $product->nombre = $this->nombre;
        $product->descripcion = $this->descripcion;
        $product->precio = $this->precio;
        $product->costo = $this->costo;
        $product->codigo_barras = $this->codigo_barras;
        $product->stock = $this->stock;
        $product->stock_minimo = $this->stock_minimo;
        $product->fecha_vencimiento = $this->fecha_vencimiento;
        $product->categoria_id = $this->categoria_id;
        $product->con_iva = $this->con_iva;
        $product->estado = $this->estado;
        $product->imagen = $this->imagen;

        $product->update();

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalProduct');
        $this->dispatch('msg','Producto actualizado exitosamente');

        $this->reset(['nombre','descripcion','precio','costo','codigo_barras','stock','stock_minimo','fecha_vencimiento','categoria_id','con_iva','estado','imagen']);

    }

    #[On('destroyProduct')]
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        $this->dispatch('msg','Producto ha sido eliminada exitosamente');
    }

}
