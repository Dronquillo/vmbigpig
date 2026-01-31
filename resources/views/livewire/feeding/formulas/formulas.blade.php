<div>
    {{-- Header card with actions --}}
    <x-card cardTitle="Fórmulas de Alimentación">
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click="crear">
                <i class="fas fa-plus-circle"></i> Nueva fórmula
            </a>
        </x-slot>

        {{-- Table of formulas --}}
        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Notas</th>
                <th>Composición</th>
                <th style="width: 140px;">Acciones</th>
            </x-slot>

            @forelse($formulas as $formula)
                <tr>
                    <td>{{ $formula->id }}</td>
                    <td>{{ $formula->name }}</td>
                    <td>{{ $formula->notes }}</td>
                    <td>
                        @if($formula->items->isEmpty())
                            <span class="badge badge-secondary">Sin items</span>
                        @else
                            @foreach($formula->items as $item)
                                <span class="badge badge-info mr-1 mb-1">
                                    {{ $item->producto->nombre }} ({{ number_format($item->percentage, 2) }}%)
                                </span>
                            @endforeach
                            @php
                                $totalPct = $formula->items->sum('percentage');
                            @endphp
                            <span class="badge {{ $totalPct == 100.0 ? 'badge-success' : 'badge-warning' }} ml-1">
                                Total: {{ number_format($totalPct, 2) }}%
                            </span>
                        @endif
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-info" title="Editar" wire:click="edit({{ $formula->id }})">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-danger" title="Eliminar" wire:click="destroy({{ $formula->id }})">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay registros</td>
                </tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $formulas->links() }}
        </x-slot:cardFooter>
    </x-card>

    {{-- Modal for create/update --}}
    <x-modal modalId="modalFormula" modalTitle="Fórmula de Alimentación" modalSize="modal-lg">
        <form wire:submit.prevent="{{ $Id == 0 ? 'store' : 'update('.$Id.')' }}">
            {{-- Basic info --}}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Nombre</label>
                    <input id="name" type="text" class="form-control" placeholder="Starter / Grower / Finisher" wire:model.defer="name">
                    @error('name')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="notes">Notas</label>
                    <textarea id="notes" class="form-control" rows="2" placeholder="Observaciones de la fórmula" wire:model.defer="notes"></textarea>
                    @error('notes')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Composition section --}}
            <div class="card mb-4">
                <div class="card-header bg-info text-white">Composición (% por producto)</div>
                <div class="card-body">
                    @foreach($items as $index => $item)
                        <div class="form-row align-items-center mb-2">
                            <div class="col-md-4">
                                <label class="sr-only">Producto</label>
                                <select class="form-control" wire:model="items.{{ $index }}.producto_id">
                                    <option value="">-- Seleccione producto --</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('items.'.$index.'.producto_id')
                                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label class="sr-only">Cantidad</label>
                                <input type="number"
                                       class="form-control"
                                       placeholder="Cantidad"
                                       step="0.01" min="0" max="100"
                                       wire:model="items.{{ $index }}.cantidad">
                            </div>
                            <div class="col-md-2">
                                <label class="sr-only">Medida: </label>
                                <select wire:model="items.{{ $index }}.medida_id" class='form-control'>
                                    <option value="">--Seleccione--</option>
                                    @foreach($medidas as $medida)
                                        <option value="{{$medida->id}}">{{$medida->nombre}}</option>
                                    @endforeach
                                </select>                    
                                @error('items.'.$index.'.medida_id') 
                                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                                @enderror
                            </div>                            
                            <div class="col-md-2">
                                <label class="sr-only">Porcentaje</label>
                                <input type="number"
                                       class="form-control"
                                       placeholder="%"
                                       step="0.01" min="0" max="100"
                                       wire:model="items.{{ $index }}.percentage">
                                @error('items.'.$index.'.percentage')
                                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 text-right">
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        wire:click="removeItem({{ $index }})">
                                    <i class="far fa-trash-alt"></i> Quitar
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <button type="button" class="btn btn-primary btn-sm" wire:click="addItem">
                        <i class="fas fa-plus"></i> Agregar item
                    </button>

                    {{-- Totals and hints --}}
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

            {{-- Duplicate check --}}
            @php
                $ids = collect($items)->pluck('producto_id')->filter();
                $duplicados = $ids->count() !== $ids->unique()->count();
            @endphp
            @if($duplicados)
                <div class="alert alert-warning">
                    Hay productos repetidos en la fórmula. Revisa la composición para evitar duplicidades.
                </div>
            @endif

            {{-- Actions --}}
            <div class="clearfix">
                <button type="submit" class="btn btn-success float-right">
                    {{ $Id == 0 ? 'Guardar Fórmula' : 'Actualizar Fórmula' }}
                </button>
            </div>
        </form>
    </x-modal>
</div>

