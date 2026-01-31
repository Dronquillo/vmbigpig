<div>
    <x-card cardTitle='Gestión de Galpones ({{$this->totalRegistros}})'>
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Crear Galpón
            </a>
        </x-slot:cardTools>

        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Buscar por nombre/tipo/granja" wire:model.debounce.500ms="search">
            </div>
        </div>

        <x-table>
            <x-slot:thead>
                <th>Id</th>
                <th>Granja</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Capacidad</th>
                <th>Acciones</th>
            </x-slot:thead>

            @forelse($barns as $barn)
                <tr>
                    <td>{{ $barn->id }}</td>
                    <td>{{ $barn->farm?->name ?? $barn->farm_id }}</td>
                    <td>{{ $barn->name }}</td>
                    <td>{{ $barn->type }}</td>
                    <td>{{ $barn->capacity }}</td>
                    <td>
                        <a href="#" wire:click='edit({{ $barn->id }})' class="btn btn-sm btn-info" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>
                        <a wire.click="$dispatch('delete',{id: {{ $barn->id }}, eventName:'destroyBarn'})" class="btn btn-sm btn-danger" title="Eliminar">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No hay registros</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $barns->links() }}
        </x-slot:cardFooter>
    </x-card>

    <x-modal modalId="modalBarn" modalTitle="Galpón">
        <form wire:submit={{ $Id==0 ? "store" : "update($Id)" }}>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Granja</label>
                    <select class="form-control" wire:model="farm_id">
                        <option value="">-- Seleccione --</option>
                        @foreach($farms as $farm)
                            <option value="{{ $farm->id }}">{{ $farm->name }}</option>
                        @endforeach
                    </select>
                    @error('farm_id') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Nombre</label>
                    <input type="text" class="form-control" wire:model="name" placeholder="Galpón A">
                    @error('name') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Tipo</label>
                    <select class="form-control" wire:model="type">
                        @foreach($types as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                    @error('type') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label>Capacidad</label>
                    <input type="number" class="form-control" wire:model="capacity" min="0" placeholder="0">
                    @error('capacity') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-success float-right">
                {{ $Id==0 ? "Guardar Galpón" : "Editar Galpón" }}
            </button>
        </form>
    </x-modal>
</div>
