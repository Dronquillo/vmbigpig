<?php

namespace App\Livewire\Farms;

use Livewire\Component;

use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\Activovivo;

//Traer las tablas de categorias, medidas y empresas
use App\Models\CategoriaActivo as Categoactivo;
use App\Models\TablaMedida as Measurement;
use App\Models\Empresa as Enterprise;

use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Title('Cerdos')]
class FarmComponent extends Component
{

    use WithPagination;
    use WithFileUploads;

    //propiedades clase
    public $search = '';
    public $totalRegistros = 0;
    public $cant=5;

    //propiedades modelo
    public $Id;
    public $codigo;
    public $nombre;
    public $fecha_nacemiento;
    public $hora_nacimiento;
    public $numero_camada;
    public $raza;
    public $genero;
    public $peso;
    public $medida_id;
    public $estado_salud;
    public $categoria_id;
    public $estado;
    public $empresa_id;    

    public function render()
    {

        if( $this->search !='' ){
            $this->resetPage();
        }

        $this->totalRegistros = Activovivo::count();

        $categorias = Categoactivo::All();
        $medidas = Measurement::All();
        $empresas = Enterprise::All();

        $activovivos = Activovivo::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('id','desc')
            ->paginate($this->cant);

        return view('livewire.farms.farm-component',[
            'activovivos' => $activovivos, 'categorias' => $categorias, 'medidas' => $medidas,
            'empresas' => $empresas
        ]);

    }

    public function create()
    {
        $this->Id = 0;
        $this->reset(['codigo']);
        $this->reset(['nombre']);
        $this->reset(['fecha_nacemiento']);
        $this->reset(['hora_nacimiento']);
        $this->reset(['numero_camada']);
        $this->reset(['raza']);
        $this->reset(['genero']);
        $this->reset(['peso']);
        $this->reset(['medida_id']);
        $this->reset(['categoria_id']);
        $this->reset(['estado_salud']);
        $this->reset(['empresa_id']);
        $this->estado = 'Activo';
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalFarms');
        
    }

    public function store()
    {
        $rules = [
            'codigo' => 'required|min:5',
            'nombre' => 'required|min:5|max:255|unique:activovivos',
            'hora_nacimiento' => 'required',
            'numero_camada' => 'numeric',
            'raza' => 'required',
            'genero' => 'required',
            'peso' => 'required|numeric',
            'empresa_id' => 'required',  
        ];

        $this->validate($rules);

        //crear cerdo
        $activovivos = new Activovivo();
        $activovivos->codigo = $this->codigo;
        $activovivos->nombre = $this->nombre;
        $activovivos->fecha_nacemiento = $this->fecha_nacemiento;
        $activovivos->hora_nacimiento = $this->hora_nacimiento;
        $activovivos->numero_camada = $this->numero_camada;
        $activovivos->raza = $this->raza;
        $activovivos->genero = $this->genero;
        $activovivos->peso = $this->peso;
        $activovivos->medida_id = $this->medida_id;
        $activovivos->categoria_id = $this->categoria_id;
        $activovivos->estado_salud = $this->estado_salud;
        $activovivos->empresa_id = $this->empresa_id;
        $activovivos->estado = $this->estado;
        $activovivos->save();

        //actualizar total registros
        $this->totalRegistros = Activovivo::count();

        //resetear campo
        $this->codigo = '';
        $this->nombre = '';
        $this->fecha_nacemiento = '';
        $this->hora_nacimiento = '';
        $this->numero_camada = 0;
        $this->raza = '';
        $this->genero = '';
        $this->peso = 0;
        $this->categoria_id = 0;
        $this->medida_id = 0;
        $this->estado_salud ='';
        $this->empresa_id = 0;
        $this->estado = 'Activo';    

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalFarms');
        $this->dispatch('msg','Cerdo creado exitosamente');

    }     


    public function edit(Activovivo $activovivo)
    {
        $this->Id = $activovivo->id;
        $this->codigo = $activovivo->codigo;
        $this->nombre = $activovivo->nombre;
        $this->fecha_nacemiento = $activovivo->fecha_nacemiento;
        $this->hora_nacimiento = $activovivo->hora_nacimiento;
        $this->numero_camada = $activovivo->numero_camada;
        $this->raza = $activovivo->raza;
        $this->genero = $activovivo->genero;    
        $this->peso = $activovivo->peso;
        $this->medida_id = $activovivo->medida_id;
        $this->estado_salud = $activovivo->estado_salud;
        $this->categoria_id = $activovivo->categoria_id;
        $this->empresa_id = $activovivo->empresa_id;
        $this->estado = $activovivo->estado;


        $this->dispatch('open-modal','modalFarms');

    }    

    public function update(Activovivo $activovivo)
    {
        $rules = [
            'nombre' => 'required|min:5|max:255|unique:empresas,id,'.$this->Id,
            'hora_nacimiento' => 'required',
            'numero_camada' => 'numeric',
            'raza' => 'required',
            'genero' => 'required',
            'peso' => 'required|numeric',
            'empresa_id' => 'required',             
        ];

        $this->validate($rules);

        //actualizar categoria
        $activovivo->codigo = $this->codigo;
        $activovivo->nombre = $this->nombre;
        $activovivo->fecha_nacemiento = $this->fecha_nacemiento;
        $activovivo->hora_nacimiento = $this->hora_nacimiento;
        $activovivo->numero_camada = $this->numero_camada;
        $activovivo->raza = $this->raza;
        $activovivo->genero = $this->genero;
        $activovivo->peso = $this->peso;
        $activovivo->medida_id = $this->medida_id;
        $activovivo->categoria_id = $this->categoria_id;
        $activovivo->estado_salud = $this->estado_salud;
        $activovivo->empresa_id = $this->empresa_id;
        $activovivo->estado = $this->estado;

        $activovivo->update();

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalFarms');
        $this->dispatch('msg','Activo vivo editado exitosamente');

        $this->reset(['codigo']);
        $this->reset(['nombre']);
        $this->reset(['fecha_nacemiento']);
        $this->reset(['hora_nacimiento']);
        $this->reset(['numero_camada']);
        $this->reset(['raza']);
        $this->reset(['genero']);
        $this->reset(['peso']);
        $this->reset(['medida_id']);
        $this->reset(['categoria_id']);
        $this->reset(['estado_salud']);
        $this->reset(['empresa_id']);
        $this->estado = 'Activo';


    }  

    
}
