<?php

namespace App\Livewire\Eterprise;

use Livewire\Component;
use App\Models\Empresa as Enterprise;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[Title('Empresas')]

class EnterpriseComponent extends Component
{

    use WithPagination;

    //propiedades clase
    public $search = '';
    public $totalRegistros = 0;
    public $cant=5;
    
    //propiedades modelo
    public $nombre;
    public $Id;
    public $ruc;
    public $direccion;
    public $telefono;
    public $correo;
    public $estado;

    public function render()
    {

        if( $this->search !='' ){
            $this->resetPage();
        }

        $this->totalRegistros = Enterprise::count();
        
        $enterprises = Enterprise::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('id','desc')
            ->paginate($this->cant);

        return view('livewire.eterprise.enterprise-component',[
            'enterprises' => $enterprises
        ]);
    }


    public function mount()
    {
        $this->totalRegistros = Enterprise::count();
    }
    
    public function create()
    {
        $this->Id = 0;
        $this->reset(['ruc']);
        $this->reset(['nombre']);
        $this->reset(['direccion']);
        $this->reset(['telefono']);
        $this->reset(['correo']);
        $this->reset(['estado']);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalEnterprise');
        
    }

    //crear empresa
    public function store()
    {
        $rules = [
            'nombre' => 'required|min:5|max:255|unique:empresas',
            'ruc' => 'required|min:13|max:13|unique:empresas',
            'direccion' => 'required|min:25|max:255',
            'telefono' => 'required|min:10|max:10',
            'correo' => 'required|email'
        ];

        $messages = [
            'nombre.required' => 'El nombre de la Empresa es obligatorio',
            'nombre.min' => 'El nombre de la Empresa debe tener al menos 5 caracteres',
            'nombre.max' => 'El nombre de la Empresa no debe exceder los 255 caracteres',
            'nombre.unique' => 'Ya existe una Empresa con este nombre',
            'ruc.required' => 'El RUC de la Empresa es obligatorio',
            'ruc.min' => 'El RUC de la Empresa debe tener 13 caracteres',
            'ruc.max' => 'El RUC de la Empresa debe tener 13 caracteres',
            'ruc.unique' => 'Ya existe una Empresa con este RUC',
            'direccion.required' => 'La dirección de la Empresa es obligatoria',
            'direccion.min' => 'La dirección de la Empresa debe tener al menos 25 caracteres',
            'direccion.max' => 'La dirección de la Empresa no debe exceder los 255 caracteres',
            'telefono.required' => 'El teléfono de la Empresa es obligatorio',
            'telefono.min' => 'El teléfono de la Empresa debe tener 10 caracteres',
            'telefono.max' => 'El teléfono de la Empresa debe tener 10 caracteres',
            'correo.required' => 'El correo de la Empresa es obligatorio',
            'correo.email' => 'El correo de la Empresa debe ser una dirección de correo válida'
        ];

        $this->validate($rules, $messages);

        //crear empresa
        $enterprises = new Enterprise();
        $enterprises->ruc = $this->ruc;
        $enterprises->nombre = $this->nombre;
        $enterprises->direccion = $this->direccion;
        $enterprises->telefono = $this->telefono;
        $enterprises->correo = $this->correo;
        $enterprises->estado = 'Activo';
        $enterprises->save();

        //actualizar total registros
        $this->totalRegistros = Enterprise::count();

        //resetear campo
        $this->ruc = '';
        $this->nombre = '';
        $this->direccion = '';
        $this->telefono = '';
        $this->correo = '';
        $this->estado = 'Activo';

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalEnterprise');
        $this->dispatch('msg','Empresa creada exitosamente');

    }

    public function edit(Enterprise $enterprises)
    {
        $this->Id = $enterprises->id;
        $this->ruc = $enterprises->ruc;
        $this->nombre = $enterprises->nombre;
        $this->direccion = $enterprises->direccion;
        $this->telefono = $enterprises->telefono;
        $this->correo = $enterprises->correo;
        $this->estado = $enterprises->estado;

        $this->dispatch('open-modal','modalEnterprise');

    }

    public function update(Enterprise $enterprises)
    {
        $rules = [
            'nombre' => 'required|min:5|max:255|unique:empresas,id,'.$this->Id,
            'direccion' => 'required|min:25|max:255',
            'telefono' => 'required|min:10|max:10',
            'correo' => 'required|email'            
        ];

        $messages = [
            'nombre.required' => 'El nombre de la empresa es obligatorio',
            'nombre.min' => 'El nombre de la empresa debe tener al menos 5 caracteres',
            'nombre.max' => 'El nombre de la empresa no debe exceder los 255 caracteres',
            'nombre.unique' => 'Ya existe una empresa con este nombre',
            'ruc.required' => 'El RUC de la Empresa es obligatorio',
            'ruc.min' => 'El RUC de la Empresa debe tener 13 caracteres',
            'ruc.max' => 'El RUC de la Empresa debe tener 13 caracteres',
            'direccion.required' => 'La dirección de la Empresa es obligatoria',
            'direccion.min' => 'La dirección de la Empresa debe tener al menos 25 caracteres',
            'direccion.max' => 'La dirección de la Empresa no debe exceder los 255 caracteres',
            'telefono.required' => 'El teléfono de la Empresa es obligatorio',
            'telefono.min' => 'El teléfono de la Empresa debe tener 10 caracteres',
            'telefono.max' => 'El teléfono de la Empresa debe tener 10 caracteres',
            'correo.required' => 'El correo de la Empresa es obligatorio',
            'correo.email' => 'El correo de la Empresa debe ser una dirección de correo válida'            
        ];

        $this->validate($rules, $messages);

        //actualizar categoria
        $enterprises->nombre = $this->nombre;
        $enterprises->ruc = $this->ruc;
        $enterprises->direccion = $this->direccion;
        $enterprises->telefono = $this->telefono;
        $enterprises->correo = $this->correo;
        $enterprises->estado = $this->estado;
        $enterprises->update();

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalEnterprise');
        $this->dispatch('msg','Empresa editada exitosamente');

        $this->reset(['ruc']);
        $this->reset(['nombre']);
        $this->reset(['direccion']);
        $this->reset(['telefono']);
        $this->reset(['correo']);
        $this->reset(['estado']);


    }    


}
