<?php

namespace App\Livewire\Partos;

namespace App\Livewire\Partos;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\TablaPartos as TablaParto;
use App\Models\TablaPartoEstado;
use App\Models\ActivoVivo;
use App\Models\Personal;
use App\Models\lots as Lot;
use App\Models\barns as Barn;

#[Title('Partos')]
class PartoComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $totalRegistros = 0;
    public $cant = 10;

    public $Id = 0;
    public $id_activo;
    public $numero_camada;
    public $reproductor;
    public $fecha_parto;
    public $hora_parto;
    public $id_personal;
    public $numero_crias;
    public $observaciones;
    public $barn_id;

    public $estados = []; // ['numero_camada','genero','estado','observaciones']

    // Configurables (ajusta según tu sistema)
    protected $defaultMedidaId = 1;      // Unidad/medida por defecto
    protected $defaultCategoriaId = 1;   // Categoría por defecto
    protected $defaultEmpresaId = 1;     // Empresa por defecto

    public function mount()
    {
        $this->totalRegistros = TablaParto::count();
    }

    public function render()
    {
        if ($this->search !== '') $this->resetPage();

        $this->totalRegistros = TablaParto::count();

        $partos = TablaParto::with(['estados','activo','personal'])
            ->when($this->search !== '', function ($q) {
                $q->whereHas('activo', fn($qq) => $qq->where('codigo', 'like', '%'.$this->search.'%'))
                  ->orWhere('reproductor', 'like', '%'.$this->search.'%')
                  ->orWhere('observaciones', 'like', '%'.$this->search.'%');
            })
            ->orderBy('fecha_parto','desc')
            ->paginate($this->cant);

        $activos   = ActivoVivo::where('genero', 'Hembra')->orderBy('codigo')->get();
        $personales = Personal::orderBy('nombre')->get();
        $barns      = Barn::orderBy('name')->get();

        return view('livewire.partos.partos', compact('partos','activos','personales','barns'));

    }

    public function create()
    {
        $this->Id = 0;

        $this->reset([
            'id_activo','numero_camada',
            'reproductor','fecha_parto','hora_parto','id_personal','numero_crias',
            'observaciones','estados',
        ]);

        $this->resetErrorBag();

        // Inicializa estados según numero_crias (si ya existe valor)
        if ($this->numero_crias && $this->numero_crias > 0) {
            $this->estados = [];
            for ($i = 1; $i <= $this->numero_crias; $i++) {
                $this->estados[] = [
                    'numero_camada' => $i,
                    'genero' => 'macho',
                    'estado' => 'vivo',
                    'observaciones' => '',
                ];
            }
        }

        $this->dispatch('open-modal','modalParto');

    }

    public function store()
    {
        
        $data = $this->validate($this->rules());
        
        if (empty($data['reproductor'])) {
            $data['reproductor'] = 'Desconocido'; // o cualquier valor por defecto
        }

        DB::transaction(function () use ($data) {
            // 1) Crear Parto
            $parto = TablaParto::create($data);

            // 2) Crear Lote
            $code   = 'LOT-' . now()->format('Ymd') . '-' . $parto->id;
            $lote   = Lot::create([
                'barn_id'       => $this->barn_id,
                'code'          => $code,
                'start_date'    => $data['fecha_parto'],
                'end_date'      => null,
                'initial_count' => $data['numero_crias'],
                'current_count' => $data['numero_crias'],
            ]);

            // 3) Crear crías en activovivos y estados del parto
            $estados = $this->buildEstadosArray();
            for ($i = 1; $i <= $data['numero_crias']; $i++) {
                $estadoCria = $estados[$i-1] ?? ['genero' => 'macho', 'estado' => 'vivo', 'observaciones' => ''];

                // Activovivo (cría)
                $codigo = 'CERDO-' . $lote->code . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
                ActivoVivo::create([
                    'codigo'           => $codigo,
                    'nombre'           => 'Lechón ' . $lote->code . ' #' . $i,
                    'fecha_nacimiento' => $data['fecha_parto'], // requiere migración de corrección
                    'hora_nacimiento'  => $data['hora_parto'] ?? null,
                    'numero_camada'    => $data['numero_camada'] ?? $i, // guarda el de parto o el secuencial
                    'color'            => null,
                    'especie'          => 'porcine',
                    'raza'             => null,
                    'genero'           => $estadoCria['genero'],
                    'peso'             => null,
                    'medida_id'        => $this->defaultMedidaId,
                    'estado_salud'     => null,
                    'categoria_id'     => $this->defaultCategoriaId,
                    'empresa_id'       => $this->defaultEmpresaId,
                    'estado'           => $estadoCria['estado'] === 'vivo' ? 'activo' : 'inactivo',
                    'lot_id'           => $lote->id,
                ]);

                // Estado de parto
                $parto->estados()->create([
                    'numero_camada' => $i,
                    'genero'        => $estadoCria['genero'],
                    'estado'        => $estadoCria['estado'],
                    'observaciones' => $estadoCria['observaciones'] ?? null,
                ]);
            }
        });

        $this->totalRegistros = TablaParto::count();

        $this->dispatch('close-modal','modalParto');
        $this->dispatch('msg','Parto, lote y crías registrados exitosamente');

        $this->resetForm();
    }

    public function edit(TablaParto $parto)
    {
        $this->Id              = $parto->id;
        $this->id_activo       = $parto->id_activo;
        $this->numero_camada   = $parto->numero_camada;
        $this->reproductor     = $parto->reproductor;
        $this->fecha_parto     = $parto->fecha_parto?->format('Y-m-d');
        $this->hora_parto      = $parto->hora_parto?->format('H:i');
        $this->id_personal     = $parto->id_personal;
        $this->numero_crias    = $parto->numero_crias;
        $this->observaciones   = $parto->observaciones;

        $this->estados = $parto->estados->map(function ($e) {
            return [
                'numero_camada' => $e->numero_camada,
                'genero'        => $e->genero,
                'estado'        => $e->estado,
                'observaciones' => $e->observaciones,
            ];
        })->toArray();

        $this->dispatch('open-modal','modalParto');
    }

    public function update(TablaParto $parto)
    {
        $data = $this->validate($this->rules());

        DB::transaction(function () use ($parto, $data) {
            $parto->update($data);
            $parto->estados()->delete();

            $estados = $this->buildEstadosArray();
            for ($i = 1; $i <= $data['numero_crias']; $i++) {
                $estadoCria = $estados[$i-1] ?? ['genero' => 'macho', 'estado' => 'vivo', 'observaciones' => ''];
                $parto->estados()->create([
                    'numero_camada' => $i,
                    'genero'        => $estadoCria['genero'],
                    'estado'        => $estadoCria['estado'],
                    'observaciones' => $estadoCria['observaciones'] ?? null,
                ]);
            }
        });

        $this->dispatch('close-modal','modalParto');
        $this->dispatch('msg','Parto actualizado exitosamente');

        $this->resetForm();
    }

    public function destroy(TablaParto $parto)
    {
        $parto->estados()->delete();
        $parto->delete();

        $this->dispatch('msg','Parto eliminado');
    }

    public function addEstado()
    {
        $this->estados[] = [
            'numero_camada' => count($this->estados) + 1,
            'genero'        => 'macho',
            'estado'        => 'vivo',
            'observaciones' => '',
        ];
    }

    public function removeEstado($index)
    {
        if (isset($this->estados[$index])) {
            array_splice($this->estados, $index, 1);
            // Reindexa numero_camada
            foreach ($this->estados as $i => $e) {
                $this->estados[$i]['numero_camada'] = $i + 1;
            }
        }
    }

    protected function rules(): array
    {
        return [
            'id_activo'       => 'required|exists:activovivos,id',
            'numero_camada'   => 'nullable|integer|min:1',
            'reproductor'     => 'nullable|string|max:100',
            'fecha_parto'     => 'required|date',
            'hora_parto'      => 'nullable|date_format:H:i',
            'id_personal'     => 'required|exists:personals,id',
            'barn_id'         => 'required|exists:barns,id',
            'numero_crias'    => 'required|integer|min:0',
            'observaciones'   => 'nullable|string',
        ];
    }

    protected function validateEstadoItem(array $item): array
    {
        $rules = [
            'numero_camada' => 'required|integer|min:1',
            'genero'        => 'required|in:macho,hembra',
            'estado'        => 'required|in:vivo,muerto',
            'observaciones' => 'nullable|string',
        ];

        return validator($item, $rules)->validate();
    }

    protected function buildEstadosArray(): array
    {
        // Si no hay estados precargados, generar por defecto según numero_crias
        if (empty($this->estados) && $this->numero_crias > 0) {
            $arr = [];
            for ($i = 1; $i <= $this->numero_crias; $i++) {
                $arr[] = ['numero_camada' => $i, 'genero' => 'macho', 'estado' => 'vivo', 'observaciones' => ''];
            }
            return $arr;
        }
        // Validar cada item
        return array_map(fn($i) => $this->validateEstadoItem($i), $this->estados);
    }

    protected function inferBarnIdFromMother($activoId): ?int
    {
        // Si el activo (madre) tiene lote y ese lote tiene barn_id, úsalo
        $madre = ActivoVivo::with('lote')->find($activoId);
        return $madre?->lote?->barn_id;
    }

    protected function resetForm()
    {
        $this->reset([
            'Id','id_activo','numero_camada',
            'reproductor','fecha_parto','hora_parto','id_personal','numero_crias',
            'observaciones','estados',
        ]);
    }
}
