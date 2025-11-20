<?php

namespace App\Livewire\Measurement;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\TablaMedida as Measurement;

#[Title('Medidas')]

class MeasurementComponent extends Component
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

        $this->totalRegistros = Measurement::count();
        
        $measurements = Measurement::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('id','desc')
            ->paginate($this->cant);        

        return view('livewire.measurement.measurement-component',[
            'measurements' => $measurements
        ]);
    }

    public function mount()
    {
        $this->totalRegistros = Measurement::count();
    }

    public function create()
    {
        $this->Id = 0;
        
        $this->reset(['nombre']);
        $this->resetErrorBag();
        $this->dispatch('open-modal','modalMeasurement');
        
    }

    public function store()
    {
        $rules = [
            'nombre' => 'required|min:5|max:255|unique:tabla_medidas'
        ];

        $messages = [
            'nombre.required' => 'El nombre de la medida es obligatorio',
            'nombre.min' => 'El nombre de la medida debe tener al menos 5 caracteres',
            'nombre.max' => 'El nombre de la medida no debe exceder los 255 caracteres',
            'nombre.unique' => 'Ya existe una medida con este nombre'
        ];

        $this->validate($rules, $messages);

        //crear medida
        $measureme = new Measurement();
        $measureme->nombre = $this->nombre;
        $measureme->save();

        //actualizar total registros
        $this->totalRegistros = Measurement::count();

        //resetear campo
        $this->nombre = '';

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalMeasurement');
        $this->dispatch('msg','Medida creada exitosamente');

    }

    public function edit(Measurement $measureme)
    {
        $this->Id = $measureme->id;
        $this->nombre = $measureme->nombre;
        $this->dispatch('open-modal','modalMeasurement');

    }

    public function update(Measurement $measureme)
    {
        $rules = [
            'nombre' => 'required|min:5|max:255|unique:tabla_medidas,id,'.$this->Id
        ];

        $messages = [
            'nombre.required' => 'El nombre de la medidas es obligatorio',
            'nombre.min' => 'El nombre de la medidas debe tener al menos 5 caracteres',
            'nombre.max' => 'El nombre de la medidas no debe exceder los 255 caracteres',
            'nombre.unique' => 'Ya existe una medidas con este nombre'
        ];

        $this->validate($rules, $messages);

        //actualizar categoria
        $measureme->nombre = $this->nombre;
        $measureme->update();

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalMeasurement');
        $this->dispatch('msg','Medida editada exitosamente');

        $this->reset(['nombre']);

    }


}
