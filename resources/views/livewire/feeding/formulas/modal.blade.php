{{-- resources/views/livewire/feeding/formulas/modal.blade.php --}}
<x-modal modalId="modalFormula" modalTitle="Fórmula de Alimentación" modalSize="modal-lg">
    <form wire:submit.prevent="{{ $Id==0 ? 'store' : 'update('.$Id.')' }}">

        {{-- Datos principales --}}
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Nombre</label>
                <input type="text" id="name" wire:model.defer="name" class="form-control" placeholder="Starter / Grower / Finisher">
                @error('name')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group col-md-6">
                <label for="notes">Notas</label>
                <textarea id="notes" wire:model.defer="notes" class="form-control" rows="2" placeholder="Observaciones de la fórmula"></textarea>
                @error('notes')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Items de la fórmula --}}
        <div class="card mb-4">
            <div class="card-header bg-info text-white">Composición (% por producto)</div>
            <div class="card-body">
                @foreach($items as $index => $item)
                    <div class="form-row align-items-center mb-2">
                        <div class="col-md-6">
                            <label class="sr-only">Producto</label>
                            <select wire:model="items.{{ $index }}.producto_id" class="form-control">
                                <option value="">-- Seleccione producto --</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>
                            @error('items.'.$index.'.producto_id')
                                <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="sr-only">Porcentaje</label>
                            <input type="number" wire:model="items.{{ $index }}.percentage" step="0.01" min="0" max="100" class="form-control" placeholder="%">
                            @error('items.'.$index.'.percentage')
                                <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 text-right">
                            <button type="button" wire:click="removeItem({{ $index }})" class="btn btn-danger btn-sm">
                                Eliminar
                            </button>
                        </div>
                    </div>
                @endforeach

                <button type="button" wire:click="addItem" class="btn btn-primary btn-sm">
                    Agregar item
                </button>

                {{-- Resumen de porcentaje total --}}
                <div class="mt-3">
                    @php
                        $total = collect($items)->sum('percentage');
                    @endphp
                    <span class="badge badge-secondary">Total: {{ number_format($total, 2) }}%</span>
                    @if($total !== 100.0)
                        <span class="badge badge-warning ml-2">Sugerido: total = 100%</span>
                    @else
                        <span class="badge badge-success ml-2">Composición balanceada</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Validación de duplicados (mensaje informativo) --}}
        @php
            $ids = collect($items)->pluck('producto_id')->filter();
            $duplicados = $ids->count() !== $ids->unique()->count();
        @endphp
        @if($duplicados)
            <div class="alert alert-warning">
                Hay productos repetidos en la fórmula. Revisa la composición para evitar duplicidades.
            </div>
        @endif

        <button type="submit" class="btn btn-success float-right">
            {{ $Id==0 ? 'Guardar Fórmula' : 'Actualizar Fórmula' }}
        </button>
    </form>
</x-modal>
