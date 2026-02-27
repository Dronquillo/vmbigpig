<?php

namespace App\Livewire\Control;

use Livewire\Component;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\Control;
use App\Models\ControlDetalle;

use App\Models\lots as Lot;
use App\Models\Activovivo;
use App\Models\Empresa;
use App\Models\Producto; 
use App\Models\Personal;


use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Control de Cerdos')]
class ControlComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $totalRegistros = 0;

    public $Id = 0;
    public $lot_id, $activovivo_id, $empresa_id;
    public $tipo, $descripcion, $cantidad, $costo, $fecha, $hora;
    public $producto_id, $veterinario_id, $inseminacion_fecha, $comentario;
    public $nuevo_lote_code, $num_cerdos;
    public $detalles = [];
    public $tipo_inseminacion, $fecha_preñez, $macho_id, $veterinario_costo;
    public $controlSeleccionado = null;

    public $lotes = [], $animals = [], $empresas = [], $productos = [], $veterinarios = [];

    public function mount()
    {
        $this->lotes = Lot::all();
        $this->empresas = Empresa::all();
        $this->productos = Producto::all();
        $this->veterinarios = Personal::whereHas('cargo', fn($q)=>$q->where('nombre','Veterinario'))->get();

        if($this->lot_id){ 
            $this->updatedLotId($this->lot_id); 
        } else { 
            $this->animals = []; 
        }
    }

    public function render()
    {
        $controles = Control::with(['lot','animal','empresa'])
            ->orderByDesc('id')->paginate($this->perPage);

        $this->totalRegistros = $controles->total();

        $empresas = Empresa::All();
        $lotes = Lot::All();
        
        // $animals = $this->lot_id 
        //     ? Activovivo::where('lot_id',$this->lot_id)->where('estado','Activo')->get() 
        //     : [];

        return view('livewire.control.control-component', [
            'controles' => $controles,
            'empresas' => $empresas,
            'lots' => $lotes,
            'animals' => $this->animals,
        ]);
    }

    public function create($tipo)
    {

        $this->resetForm();
        $this->tipo = $tipo;
        $this->dispatch('open-modal','modalControl');

    }

    public function store()
    {
        $this->validate([
            'lot_id'=>'required|exists:lots,id',
            'empresa_id'=>'required|exists:empresas,id',
            'tipo'=>'required',
            'fecha'=>'required|date',
            'hora'=>'required',
        ]);

        if($this->tipo === 'alimentacion'){

            if(count($this->detalles) === 0){ 
                throw ValidationException::withMessages([ 
                    'detalles' => 'Debe agregar al menos un producto para registrar la alimentación.' 
                ]); 
            }

            $total = 0;
            
            foreach($this->detalles as $d){

                $producto = Producto::find($d['producto_id']);
                if(!$producto){
                    $this->dispatch('msg', "El producto con ID {$d['producto_id']} no existe.");
                    return;
                }

                if($producto->stock < $d['cantidad']){
                    $this->dispatch('msg', "Stock insuficiente para {$producto->nombre}. Disponible: {$producto->stock}, solicitado: {$d['cantidad']}.");
                    return;
                }

                $producto->decrement('stock',$d['cantidad']);
                $total += $d['subtotal'];
            }

            //dd("Terminó foreach", $total);

            //dd($this->lot_id, $this->empresa_id, $this->tipo, $this->fecha, $this->hora, $this->detalles);

            //dd($this->lot_id, $this->activovivo_id, $this->empresa_id, $this->tipo, $this->descripcion, count($this->detalles), $total, $this->fecha, $this->hora);

            $control = Control::create([
                'lot_id'=>$this->lot_id,
                'activovivo_id'=>$this->activovivo_id,
                'empresa_id'=>$this->empresa_id,
                'tipo'=>'alimentacion',
                'descripcion'=>$this->descripcion,
                'cantidad'=>count($this->detalles),
                'costo'=>$total,
                'fecha'=>$this->fecha,
                'hora'=>$this->hora,
            ]);

            foreach($this->detalles as $d){
                ControlDetalle::create([
                    'control_id'=>$control->id,
                    'producto_id'=>$d['producto_id'],
                    'cantidad'=>$d['cantidad'],
                    'precio'=>$d['precio'],
                    'subtotal'=>$d['subtotal'],
                ]);
            }

        }

        if($this->tipo === 'chequeo'){

            $fechaMonta = Carbon::parse($this->fecha); // fecha del chequeo/monta 
            $fechaProximoChequeo = $fechaMonta->addDays(21); // sumar 21 días

            $animal = Activovivo::findOrFail($this->activovivo_id);
            $extra = $this->descripcion;

            dd($this->lot_id, $this->activovivo_id, $this->empresa_id, $this->tipo, $extra, $this->fecha, $this->hora);

            if($animal->genero === 'femenino' && $animal->categoria_id == 1){
                $extra .= " | Tipo: ".$this->tipo_inseminacion;
                $extra .= " | Fecha preñez: ".$this->fecha_preñez;
                if($this->macho_id){
                    $macho = Activovivo::find($this->macho_id);
                    $extra .= " | Macho: ".$macho?->codigo;
                }
            }

            Control::create([ 
                'lot_id'=>$this->lot_id, 
                'activovivo_id'=>$this->activovivo_id, 
                'empresa_id'=>$this->empresa_id, 
                'tipo'=>'chequeo', 
                'descripcion'=>$this->descripcion, 
                'fecha'=>$this->fecha, 
                'hora'=>$this->hora, 
                'tipo_inseminacion'=>$this->tipo_inseminacion, 
                'fecha_preñez'=>$fechaProximoChequeo, // se guarda la fecha calculada 
                'macho_id'=>$this->macho_id, 
                'veterinario_costo'=>$this->veterinario_costo, 
            ]);

        }


        if($this->tipo === 'parto'){
            for($i=1;$i<=$this->num_cerdos;$i++){
                $sexo = request('sexo_'.$i);
                $codigo = $this->nuevo_lote_code.strtoupper(substr($sexo,0,1)).str_pad($i,3,'0',STR_PAD_LEFT);

                Activovivo::create([
                    'codigo'=>$codigo,
                    'nombre'=>$codigo,
                    'fecha_nacimiento'=>$this->fecha,
                    'hora_nacimiento'=>$this->hora,
                    'numero_camada'=>1,
                    'genero'=>$sexo,
                    'empresa_id'=>$this->empresa_id,
                    'estado'=>'activo',
                    'lot_id'=>Lot::where('code',$this->nuevo_lote_code)->first()->id,
                ]);
            }
        }

        $this->dispatch('close-modal','modalControl');
        $this->dispatch('msg','Actividad registrada exitosamente');
        $this->resetForm();

    }

    public function edit($id)
    {
        $control = Control::findOrFail($id);

        $this->Id = $control->id;
        $this->lot_id = $control->lot_id;
        $this->activovivo_id = $control->activovivo_id;
        $this->empresa_id = $control->empresa_id;
        $this->tipo = $control->tipo;
        $this->descripcion = $control->descripcion;
        $this->cantidad = $control->cantidad;
        $this->costo = $control->costo;
        $this->fecha = $control->fecha;
        $this->hora = $control->hora;

        $this->updatedLotId($this->lot_id);
        $this->dispatch('open-modal','modalControl');
    }

    public function updatedLotId($value)
    {
        $this->animals = Activovivo::where('lot_id',$value) ->where('estado','Activo') ->get();
    }

    private function resetForm()
    {
        $this->Id = 0;

        $this->reset([
            'tipo','descripcion','cantidad','costo',
            'fecha','hora','producto_id','veterinario_id','inseminacion_fecha',
            'empresa_id','comentario','nuevo_lote_code',
            'activovivo_id','num_cerdos','lot_id'
        ]);
        $this->resetErrorBag(); 
        $this->animals = [];       

    }

    public function addDetalle() 
    { 
        if($this->producto_id && $this->cantidad){ 
            $producto = Producto::findOrFail($this->producto_id); 
            $subtotal = $producto->costo * $this->cantidad; 
            
            $this->detalles[] = [ 
                'producto_id' => $producto->id, 
                'nombre' => $producto->nombre, 
                'cantidad' => $this->cantidad, 
                'precio' => $producto->costo, 
                'subtotal' => $subtotal, 
            ]; 
            
            $this->producto_id = null; 
            $this->cantidad = null; 
        } 
    } 
    
    public function removeDetalle($index) 
    { 
        unset($this->detalles[$index]); 
        $this->detalles = array_values($this->detalles); 
    }

    public function showDetalles($id)
    {

        $control = Control::with(['detalles.producto','macho'])->findOrFail($id);
        $this->detalles = $control->detalles;
        $this->controlSeleccionado = $control;
        $this->dispatch('open-modal','modalDetalles');

    }

}
