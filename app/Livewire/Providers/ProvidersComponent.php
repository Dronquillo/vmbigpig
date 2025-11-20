<?php

namespace App\Livewire\Providers;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Proveedor as Provider;
use GuzzleHttp\Handler\Proxy;

#[Title('Proveedores')]

class ProvidersComponent extends Component
{

    use WithPagination;

    //propiedades clase
    public $search = '';
    public $totalRegistros = 0;
    public $cant=5;
    
    //propiedades modelo
    public $Id;
    public $ruc;
    public $nombre;
    public $direccion;
    public $telefono;
    public $correo;
    public $contacto;
    public $estado;
    

    public function render()
    {

        if( $this->search !='' ){
            $this->resetPage();
        }

        $this->totalRegistros = Provider::count();
        
        $providers = Provider::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('id','desc')
            ->paginate($this->cant);
            
            
        return view('livewire.providers.providers-component',[
            'providers' => $providers
        ]);

    }

    public function mount()
    {
        $this->totalRegistros = Provider::count();
    }
    
    public function create()
    {
        $this->Id = 0;
        $this->reset(['ruc']);
        $this->reset(['nombre']);
        $this->reset(['direccion']);
        $this->reset(['telefono']);
        $this->reset(['correo']);
        $this->reset(['contacto']);
        $this->reset(['estado']);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalProvider');
        
    }

    public function store()
    {
        $rules = [
            'ruc' => 'required|min:13',
            'nombre' => 'required|min:5|max:255|unique:proveedors',
            'direccion' => 'required',
            'telefono' => 'required|min:9',
            'correo' => 'required',
            'contacto' => 'required',  
        ];

        $this->validate($rules);

        //crear proveedor
        $providers = new Provider();
        $providers->ruc = $this->ruc;
        $providers->nombre = $this->nombre;
        $providers->direccion = $this->direccion;
        $providers->telefono = $this->telefono;
        $providers->correo = $this->correo;
        $providers->contacto = $this->contacto;
        $providers->estado = $this->estado;
        $providers->save();

        //actualizar total registros
        $this->totalRegistros = Provider::count();

        //resetear campo
        $this->ruc = '';
        $this->nombre = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->correo = 0;
        $this->contacto = '';
        $this->estado = 'Activo';    

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalProvider');
        $this->dispatch('msg','Proveedor creado exitosamente');

    }       

    public function edit(Provider $provider)
    {
        
        $this->Id = $provider->id;
        $this->ruc = $provider->ruc;
        $this->nombre = $provider->nombre;
        $this->direccion = $provider->direccion;
        $this->telefono = $provider->telefono;
        $this->correo = $provider->correo;
        $this->contacto = $provider->contacto;
        $this->estado = $provider->estado;

        $this->dispatch('open-modal','modalProvider');
        
    }    

    public function update(Provider $provider)
    {
        $rules = [
            'ruc' => 'required|min:13',
            'nombre' => 'required|min:5|max:255',
            'direccion' => 'required',
            'telefono' => 'required|min:9',
            'correo' => 'required',
            'contacto' => 'required',  
        ];

        $this->validate($rules);

        //actualizar proveedores
        $provider->ruc = $this->ruc;
        $provider->nombre = $this->nombre;
        $provider->direccion = $this->direccion;
        $provider->telefono = $this->telefono;
        $provider->correo = $this->correo;
        $provider->contacto = $this->contacto;
        $provider->estado = $this->estado;
        $provider->update();

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalProvider');
        $this->dispatch('msg','Proveedor actualizado exitosamente');

        $this->reset(['ruc']);
        $this->reset(['nombre']);
        $this->reset(['direccion']);
        $this->reset(['telefono']);
        $this->reset(['correo']);
        $this->reset(['contacto']);
        $this->estado = 'Activo';


    }

}
