<?php

namespace App\Livewire\Porcino;

use Livewire\Component;

use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\Activovivo;

//Traer las tablas de categorias, medidas y empresas
use App\Models\CategoriaActivo as Categoactivo;
use App\Models\TablaMedida as Measurement;
use App\Models\Empresa as Enterprise;
use App\Models\lots as Lot;

use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Title('Cerdos')]
class PorcinoComponent extends Component
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
    public $fecha_nacimiento;
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
    public $lot_id;
    public $especie='Porcino';

    public function render()
    {

        if( $this->search !='' ){
            $this->resetPage();
        }

        $this->totalRegistros = Activovivo::count();

        $categorias = Categoactivo::All();
        $medidas = Measurement::All();
        $empresas = Enterprise::All();
        $lotes = Lot::All();

        $activovivos = Activovivo::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('id','desc')
            ->paginate($this->cant);

        return view('livewire.porcino.porcino-component',[
            'activovivos' => $activovivos, 'categorias' => $categorias, 'medidas' => $medidas,
            'empresas' => $empresas, 'lotes' => $lotes
        ]);

    }

    public function create()
    {
        $this->Id = 0;
        $this->reset(['codigo']);
        $this->reset(['nombre']);
        $this->reset(['fecha_nacimiento']);
        $this->reset(['hora_nacimiento']);
        $this->reset(['numero_camada']);
        $this->reset(['raza']);
        $this->reset(['genero']);
        $this->reset(['especie']);
        $this->reset(['peso']);
        $this->reset(['medida_id']);
        $this->reset(['categoria_id']);
        $this->reset(['estado_salud']);
        $this->reset(['empresa_id']);
        $this->reset(['lot_id']);
        $this->estado = 'Activo';
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalFarms');
        
    }

    public function store()
    {
        $rules = [
            'codigo' => 'required|min:1',
            'nombre' => 'required|min:5|max:255',
            'hora_nacimiento' => 'required',
            'numero_camada' => 'numeric',
            'raza' => 'required',
            'genero' => 'required',
            'peso' => 'required|numeric',
            'empresa_id' => 'required',  
            'lot_id' => 'required',
        ];

        $this->validate($rules);

        //crear cerdo
        $activovivos = new Activovivo();
        $activovivos->codigo = $this->codigo;
        $activovivos->nombre = $this->nombre;
        $activovivos->fecha_nacimiento = $this->fecha_nacimiento;
        $activovivos->hora_nacimiento = $this->hora_nacimiento;
        $activovivos->numero_camada = $this->numero_camada;
        $activovivos->raza = $this->raza;
        $activovivos->genero = $this->genero;
        $activovivos->especie = $this->especie;
        $activovivos->peso = $this->peso;
        $activovivos->medida_id = $this->medida_id;
        $activovivos->categoria_id = $this->categoria_id;
        $activovivos->estado_salud = $this->estado_salud;
        $activovivos->empresa_id = $this->empresa_id;
        $activovivos->estado = $this->estado;
        $activovivos->lot_id = $this->lot_id;
        $activovivos->save();

        //actualizar total registros
        $this->totalRegistros = Activovivo::count();

        //resetear campo
        $this->codigo = '';
        $this->nombre = '';
        $this->fecha_nacimiento = '';
        $this->hora_nacimiento = '';
        $this->numero_camada = 0;
        $this->raza = '';
        $this->genero = '';
        $this->peso = 0;
        $this->categoria_id = 0;
        $this->medida_id = 0;
        $this->estado_salud ='';
        $this->empresa_id = 0;
        $this->lot_id = 0;
        $this->especie = 'Porcino';
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
        $this->fecha_nacimiento = $activovivo->fecha_nacimiento;
        $this->hora_nacimiento = $activovivo->hora_nacimiento;
        $this->numero_camada = $activovivo->numero_camada;
        $this->raza = $activovivo->raza;
        $this->genero = $activovivo->genero;    
        $this->peso = $activovivo->peso;
        $this->especie = $activovivo->especie;
        $this->medida_id = $activovivo->medida_id;
        $this->estado_salud = $activovivo->estado_salud;
        $this->categoria_id = $activovivo->categoria_id;
        $this->empresa_id = $activovivo->empresa_id;
        $this->lot_id = $activovivo->lot_id;
        $this->estado = $activovivo->estado;

        $this->dispatch('open-modal','modalFarms');

    }    

    //|unique:empresas,id,'.$this->Id

    public function update(Activovivo $activovivo)
    {
        $rules = [
            'nombre' => 'required|min:5|max:255',
            'hora_nacimiento' => 'required',
            'numero_camada' => 'numeric',
            'raza' => 'required',
            'genero' => 'required',
            'peso' => 'required|numeric',
            'empresa_id' => 'required', 
            'lot_id' => 'required',            
        ];

        $this->validate($rules);

        //actualizar categoria
        $activovivo->codigo = $this->codigo;
        $activovivo->nombre = $this->nombre;
        $activovivo->fecha_nacimiento = $this->fecha_nacimiento;
        $activovivo->hora_nacimiento = $this->hora_nacimiento;
        $activovivo->numero_camada = $this->numero_camada;
        $activovivo->raza = $this->raza;
        $activovivo->genero = $this->genero;
        $activovivo->peso = $this->peso;
        $activovivo->medida_id = $this->medida_id;
        $activovivo->categoria_id = $this->categoria_id;
        $activovivo->estado_salud = $this->estado_salud;
        $activovivo->empresa_id = $this->empresa_id;
        $activovivo->lot_id = $this->lot_id;
        $activovivo->estado = $this->estado;
        $activovivo->especie = $this->especie;

        $activovivo->update();

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalFarms');
        $this->dispatch('msg','Activo vivo editado exitosamente');

        $this->reset(['codigo']);
        $this->reset(['nombre']);
        $this->reset(['fecha_nacimiento']);
        $this->reset(['hora_nacimiento']);
        $this->reset(['numero_camada']);
        $this->reset(['raza']);
        $this->reset(['genero']);
        $this->reset(['peso']);
        $this->reset(['medida_id']);
        $this->reset(['categoria_id']);
        $this->reset(['estado_salud']);
        $this->reset(['empresa_id']);
        $this->reset(['lot_id']);
        $this->reset(['especie']);
        $this->estado = 'Activo';


    }  

}
