<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\Cliente;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\WithPagination;


#[Title('Clientes')]

class ClientComponent extends Component
{

    use WithPagination;

    //propiedades clase
    public $search = '';
    public $totalRegistros = 0;
    public $cant=5;
    
    //propiedades modelo
    public $Id;    
    public $cedularuc;
    public $nombre;
    public $direccion;
    public $telefono;
    public $correo;
    public $estado;    

    public function render()
    {

        if( $this->search !='' ){
            $this->resetPage();
        }

        $this->totalRegistros = Cliente::count();
        
        $clientes = Cliente::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('id','desc')
            ->paginate($this->cant);

        return view('livewire.client.client-component',[
            'clientes' => $clientes
        ]);
    }

    public function mount(){
        $this->totalRegistros = Cliente::count();
    }

    public function create(){

        $this->Id=0;

        $this->clean();
        $this->dispatch('open-modal','modalClient');

    }

    public function store(){
        $rules = [
            'cedularuc' => 'required|min:10|max:13',
            'nombre' => 'required|min:5|max:255|unique:clientes',
            'direccion' => 'required',
            'telefono' => 'required|min:9',
            'correo' => 'required',
 
        ];

        $this->validate($rules);

        //crear cliente
        $clientes = new Cliente();
        $clientes->cedularuc = $this->cedularuc;
        $clientes->nombre = $this->nombre;
        $clientes->direccion = $this->direccion;
        $clientes->telefono = $this->telefono;
        $clientes->correo = $this->correo;
        $clientes->estado = $this->estado;
        $clientes->save();

        //actualizar total registros
        $this->totalRegistros = Cliente::count();

        //resetear campo
        $this->cedularuc = '';
        $this->nombre = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->correo = 0;
        $this->estado = 'Activo';    

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalClient');
        $this->dispatch('msg','Cliente creado exitosamente');

    } 
    
    public function edit(Cliente $cliente)
    {
        
        $this->Id = $cliente->id;
        $this->cedularuc = $cliente->cedularuc;
        $this->nombre = $cliente->nombre;
        $this->direccion = $cliente->direccion;
        $this->telefono = $cliente->telefono;
        $this->correo = $cliente->correo;
        $this->estado = $cliente->estado;

        $this->dispatch('open-modal','modalClient');
        
    }    

    public function update(Cliente $cliente)
    {
        $rules = [
            'cedularuc' => 'required|min:10|max:13',
            'nombre' => 'required|min:5|max:255',
            'direccion' => 'required',
            'telefono' => 'required|min:9',
            'correo' => 'required',
 
        ];

        $this->validate($rules);

        //actualizar proveedores
        $cliente->cedularuc = $this->cedularuc;
        $cliente->nombre = $this->nombre;
        $cliente->direccion = $this->direccion;
        $cliente->telefono = $this->telefono;
        $cliente->correo = $this->correo;
        $cliente->estado = $this->estado;
        $cliente->update();

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalClient');
        $this->dispatch('msg','Proveedor actualizado exitosamente');
        $this->clean();

    }    


    public function clean(){

        $this->reset(['nombre','cedularuc','direccion','telefono','correo','estado']);
        $this->resetErrorBag();
    }    

}
