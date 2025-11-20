<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\Categoria as Category;
use Livewire\WithPagination;

#[Title('Categorias')]

class CategoryComponent extends Component
{
    use WithPagination;

    //propiedades clase
    public $search = '';
    public $totalRegistros = 0;
    public $cant=5;
    
    //propiedades modelo
    public $nombre;
    public $Id;

    public function render()
    {
        if( $this->search !='' ){
            $this->resetPage();
        }

        $this->totalRegistros = Category::count();
        
        $categories = Category::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('id','desc')
            ->paginate($this->cant);

        return view('livewire.category.category-component',[
            'categories' => $categories
        ]);

    }

    public function mount()
    {
        $this->totalRegistros = Category::count();
    }

    public function create()
    {
        $this->Id = 0;
        
        $this->reset(['nombre']);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalCategory');
        
    }

    //crear categoria
    public function store()
    {
        $rules = [
            'nombre' => 'required|min:5|max:255|unique:categorias'
        ];

        $messages = [
            'nombre.required' => 'El nombre de la categoria es obligatorio',
            'nombre.min' => 'El nombre de la categoria debe tener al menos 5 caracteres',
            'nombre.max' => 'El nombre de la categoria no debe exceder los 255 caracteres',
            'nombre.unique' => 'Ya existe una categoria con este nombre'
        ];

        $this->validate($rules, $messages);

        //crear categoria
        $category = new Category();
        $category->nombre = $this->nombre;
        $category->save();

        //actualizar total registros
        $this->totalRegistros = Category::count();

        //resetear campo
        $this->nombre = '';

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalCategory');
        $this->dispatch('msg','Categoria creada exitosamente');

    }

    public function edit(Category $category)
    {
        $this->Id = $category->id;
        $this->nombre = $category->nombre;
        $this->dispatch('open-modal','modalCategory');

    }

    public function update(Category $category)
    {
        $rules = [
            'nombre' => 'required|min:5|max:255|unique:categorias,id,'.$this->Id
        ];

        $messages = [
            'nombre.required' => 'El nombre de la categoria es obligatorio',
            'nombre.min' => 'El nombre de la categoria debe tener al menos 5 caracteres',
            'nombre.max' => 'El nombre de la categoria no debe exceder los 255 caracteres',
            'nombre.unique' => 'Ya existe una categoria con este nombre'
        ];

        $this->validate($rules, $messages);

        //actualizar categoria
        $category->nombre = $this->nombre;
        $category->update();

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalCategory');
        $this->dispatch('msg','Categoria editada exitosamente');

        $this->reset(['nombre']);

    }

    #[On('destroyCategory')]
    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        $this->dispatch('msg','Categoria ha sido eliminada exitosamente');
    }

}
