<div>
    <x-card cardTitle='Gestión de Lotes ({{$this->totalRegistros}})'>
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Crear Lote
            </a>
        </x-slot:cardTools>

        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Buscar por código/galpón" wire:model.debounce.500ms="search">
            </div>
        </div>

        <x-table>
            <x-slot:thead>
                <th>Id</th>
                <th>Código</th>
                <th>Galpón</th>
                <th>Inicio</th>
                <th>Cierre</th>
                <th>Inicial</th>
                <th>Actual</th>
                <th>Acciones</th>
            </x-slot:thead>

            @forelse($lots as $lot)
                <tr>
                    <td>{{ $lot->id }}</td>
                    <td>{{ $lot->code }}</td>
                    <td>{{ $lot->barn?->name ?? $lot->barn_id }}</td>
                    <td>{{ $lot->start_date?->format('Y-m-d') }}</td>
                    <td>{{ $lot->end_date?->format('Y-m-d') ?? '—' }}</td>
                    <td>{{ $lot->initial_count }}</td>
                    <td>{{ $lot->current_count }}</td>
                    <td>
                        <a href="#" wire:click='edit({{ $lot->id }})' class="btn btn-sm btn-info" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="#" wire:click='closeLot({{ $lot->id }})' class="btn btn-sm btn-warning" title="Cerrar Lote">
                            <i class="fas fa-lock"></i>
                        </a>
                        <a wire.click="$dispatch('delete',{id: {{ $lot->id }}, eventName:'destroyLot'})" class="btn btn-sm btn-danger" title="Eliminar">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">No hay registros</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $lots->links() }}
        </x-slot:cardFooter>
    </x-card>

    <x-modal modalId="modalLot" modalTitle="Lote">
        <form wire:submit={{ $Id==0 ? "store" : "update($Id)" }}>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Galpón</label>
                    <select class="form-control" wire:model="barn_id">
                        <option value="">-- Seleccione --</option>
                        @foreach($barns as $barn)
                            <option value="{{ $barn->id }}">{{ $barn->name }}</option>
                        @endforeach
                    </select>
                    @error('barn_id') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Código</label>
                    <input type="text" class="form-control" wire:model="code" placeholder="L-2025-001">
                    @error('code') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Fecha inicio</label>
                    <input type="date" class="form-control" wire:model="start_date">
                    @error('start_date') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Fecha cierre</label>
                    <input type="date" class="form-control" wire:model="end_date">
                    @error('end_date') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Conteo inicial</label>
                    <input type="number" class="form-control" wire:model="initial_count" min="0">
                    @error('initial_count') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Conteo actual</label>
                    <input type="number" class="form-control" value="{{ $current_count }}" readonly>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <h6>Cerdos disponibles</h6>
                    <div class="table-responsive" style="max-height: 260px; overflow-y: auto;">
                        <table class="table table-sm">
                            <thead><tr><th></th><th>ID</th><th>Código</th><th>Nombre</th></tr></thead>
                            <tbody>
                                @forelse($availablePigs as $pig)
                                    <tr>
                                        <td><input type="checkbox" wire:model="selectedPigs" value="{{ $pig->id }}"></td>
                                        <td>{{ $pig->id }}</td>
                                        <td>{{ $pig->codigo }}</td>
                                        <td>{{ $pig->nombre }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4">No hay cerdos disponibles</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mt-2" wire:click="assignSelectedPigs" @disabled($Id==0)>
                        Asignar seleccionados
                    </button>
                </div>

                <div class="col-md-6">
                    <h6>Cerdos en el lote</h6>
                    <div class="table-responsive" style="max-height: 260px; overflow-y: auto;">
                        <table class="table table-sm">
                            <thead><tr><th></th><th>ID</th><th>Código</th><th>Nombre</th></tr></thead>
                            <tbody>
                                @forelse($lotPigs as $pig)
                                    <tr>
                                        <td><input type="checkbox" wire:model="selectedLotPigIds" value="{{ $pig->id }}"></td>
                                        <td>{{ $pig->id }}</td>
                                        <td>{{ $pig->codigo }}</td>
                                        <td>{{ $pig->nombre }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4">No hay cerdos en el lote</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm mt-2" wire:click="removeSelectedLotPigs" @disabled($Id==0)>
                        Remover seleccionados
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-success float-right">
                {{ $Id==0 ? "Guardar Lote" : "Editar Lote" }}
            </button>
        </form>
    </x-modal>
</div>
