<?php

namespace App\Livewire\Compra;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Empresa;
use App\Models\Producto;

#[Title('Compra a Proveedor')]
class CompraComponent extends Component
{
    use WithPagination;

    // Paginación y búsqueda
    public $search = '';
    public $perPage = 5;
    public $totalRegistros = 0;

    // Cabecera
    public $Id=0, $compraId = 0;
    public $proveedor_id, $nombre, $numero_factura, $empresa_id, $fecha, $estado = 'ACTIVO';
    public $porc_iva = 15;
    public $subtotal = 0, $descuento = 0, $iva = 0, $total = 0;

    // Detalles
    public $detalles = [];
    public $producto_id, $cantidad, $precio_compra, $detalle_descuento = 0, $detalle_iva = 0 , $porc_ivas = 15;

    // Listas
    public $proveedores = [], $empresas = [], $productos = [];

    public function mount()
    {
        $this->proveedores = Proveedor::all();
        $this->empresas = Empresa::all();
        $this->productos = Producto::all();
    }

    public function render()
    {
        if ($this->search !== '') {
            $this->resetPage();
        }

        $this->totalRegistros = Compra::count();

        $compras = Compra::where('nombre', 'like', "%{$this->search}%")
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.compra.compra-component', [
            'compras' => $compras,
            'proveedores' => $this->proveedores,
            'empresas' => $this->empresas,
            'productos' => $this->productos,
        ]);

    }

    public function create()
    {
        $this->resetFormulario();
        $this->dispatch('open-modal','modalCompra');
    }

    // 🔹 Reset de formulario
    public function resetFormulario()
    {
        $this->compraId = 0;
        $this->reset([
            'fecha','proveedor_id','nombre','numero_factura',
            'subtotal','descuento','porc_iva','iva','total',
            'empresa_id','estado','detalles',
            'producto_id','cantidad','precio_compra','detalle_descuento','detalle_iva','porc_ivas'
        ]);
        $this->resetErrorBag();
    }

    // 🔹 Validación
    protected function rules()
    {
        return [
            'proveedor_id' => 'required',
            'numero_factura' => 'required|string',
            'empresa_id' => 'required',
            'fecha' => 'required|date',
        ];
    }

    protected function messages()
    {
        return [
            'proveedor_id.required' => 'El proveedor es requerido',
            'numero_factura.required' => 'El número de factura es requerido',
            'empresa_id.required' => 'La empresa es requerida',
            'fecha.required' => 'La fecha de compra es requerida',
        ];
    }

    // 🔹 Guardar compra
    public function store()
    {
        $this->validate();

        $this->guardarCompra();

        $this->totalRegistros = Compra::count();
        $this->dispatch('close-modal','modalCompra');
        $this->dispatch('msg','Compra creada exitosamente');

    }

    // 🔹 Calcular detalle temporal
    public function calcularDetalle()
    {
        if (!$this->producto_id || !$this->cantidad || !$this->precio_compra) return null;

        $subtotal = $this->cantidad * $this->precio_compra;
        $descuento = $this->detalle_descuento ?? 0;
        $iva = ($subtotal - $descuento) * ($this->porc_ivas / 100);

        $this->detalle_iva = $iva;

        return [
            'producto_id' => $this->producto_id,
            'cantidad' => $this->cantidad,
            'precio_compra' => $this->precio_compra,
            'porc_iva' => $this->porc_ivas,
            'descuento' => $descuento,
            'iva' => $iva,
            'subtotal' => $subtotal ,
        ];
        
    }

    // 🔹 Agregar detalle
    public function addDetalle()
    {
        $this->detalles[] = [
            'producto_id'   => $this->producto_id,
            'cantidad'      => $this->cantidad,
            'precio_compra' => $this->precio_compra,
            'porc_iva'      => $this->porc_ivas,
            'descuento'     => $this->detalle_descuento,
            'iva'           => $this->calcularIva($this->precio_compra, $this->cantidad, $this->porc_ivas),
            'subtotal'      => $this->calcularSubtotal($this->precio_compra, $this->cantidad, $this->detalle_descuento),
        ];

        $this->reset(['producto_id','cantidad','precio_compra','detalle_descuento','porc_ivas']);
        $this->calcularTotales();
    }    

    private function calcularIva($precio, $cantidad, $porc)
    {
        return (($precio * $cantidad) * $porc) / 100;
    }

    private function calcularSubtotal($precio, $cantidad, $descuento)
    {
        return ($precio * $cantidad) - $descuento;
    }

    // 🔹 Totales
    public function calcularTotales()
    {
        $this->subtotal = collect($this->detalles)->sum('subtotal');
        $this->descuento = collect($this->detalles)->sum('descuento');
        $this->iva = collect($this->detalles)->sum('iva');
        $this->total = $this->subtotal - $this->descuento + $this->iva;
    }

    // 🔹 Persistencia
    public function guardarCompra()
    {
        $compra = Compra::create([
            'proveedor_id' => $this->proveedor_id,
            'nombre' => $this->nombre,
            'numero_factura' => $this->numero_factura,
            'empresa_id' => $this->empresa_id,
            'fecha' => $this->fecha,
            'subtotal' => $this->subtotal,
            'descuento' => $this->descuento,
            'porc_iva' => $this->porc_iva,
            'iva' => $this->iva,
            'total' => $this->total,
            'estado' => $this->estado ?? 'ACTIVO' ,
        ]);

        foreach ($this->detalles as $detalle) {
            $compra->detalles()->create($detalle);
        }

    }

    // 🔹 Eventos reactivos
    public function updatedProveedorId($value)
    {
        $proveedor = Proveedor::find($value);
        $this->nombre = $proveedor?->nombre ? $proveedor?->nombre : '';
    }

    public function updatedProductoId($value)
    {
        $producto = Producto::find($value);
        if ($producto) {
            $this->precio_compra = $producto->precio_compra;
            $this->porc_ivas = $producto->iva ? 0 : 15 ;
        }
    }

    public function updatedCantidad($value)
    {
        $this->calcularDetalle();
    }

    public function edit(Compra $compra)
    {

        $this->Id = $compra->id;
        $this->proveedor_id   = $compra->proveedor_id;
        $this->nombre         = $compra->nombre;
        $this->numero_factura = $compra->numero_factura;
        $this->empresa_id     = $compra->empresa_id;
        $this->fecha          = $compra->fecha;
        $this->subtotal       = $compra->subtotal; 
        $this->descuento      = $compra->descuento;
        $this->porc_iva       = $compra->porc_iva;
        $this->iva            = $compra->iva;
        $this->total          = $compra->total;
        $this->estado         = $compra->estado;

        // Cargar detalles en arreglo
        $this->detalles = $compra->detalles->map(function($d) {
            return [
                'producto_id'   => $d->producto_id,
                'cantidad'      => $d->cantidad,
                'precio_compra' => $d->precio_compra,
                'porc_iva'      => $d->porc_iva,
                'descuento'     => $d->descuento,
                'iva'           => $d->iva,
                'subtotal'      => $d->subtotal,
            ];
        })->toArray();

        $this->dispatch('open-modal','modalCompra');

    }

    public function update($id)
    {
        
        $this->validate();

        $compra = Compra::findOrFail($id);

        $compra->update($this->only([
            'proveedor_id','nombre','numero_factura','empresa_id','fecha',
            'subtotal','descuento','porc_iva','iva','total','estado'
        ]));

        // Actualizar detalles: primero limpiar, luego insertar
        $compra->detalles()->delete();

        foreach ($this->detalles as $d) {
            $compra->detalles()->create($d);
        }

        //cerrar modal via browser event
        $this->dispatch('close-modal','modalCompra');
        $this->dispatch('msg','Compra editada exitosamente');

        $this->resetFormulario();

    } 

    public function updatedDetalles()
    {
        $this->subtotal = collect($this->detalles)->sum('subtotal');
        $this->descuento = collect($this->detalles)->sum('descuento');
        $this->iva = collect($this->detalles)->sum('iva');
        $this->total = $this->subtotal - $this->descuento + $this->iva;
    }

    public function removeDetalle($index)
    {
        unset($this->detalles[$index]);
        $this->detalles = array_values($this->detalles); // reindexar
    }    




}

