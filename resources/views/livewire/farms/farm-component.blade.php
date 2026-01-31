<div>
    <x-card cardTitle='Gestión de Granjas ({{$this->totalRegistros}})'>
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Crear Granja
            </a>
        </x-slot:cardTools>

        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Buscar por nombre/ubicación" wire:model.debounce.500ms="search">
            </div>
        </div>

        <x-table>
            <x-slot:thead>
                <th>Id</th>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Responsable</th>
                <th>Estado</th>
                <th>Acciones</th>
            </x-slot:thead>

            @forelse($farms as $farm)
                <tr>
                    <td>{{ $farm->id }}</td>
                    <td>{{ $farm->name }}</td>
                    <td>{{ $farm->location }}</td>
                    <td>{{ $farm->owner }}</td>
                    <td>{{ $farm->estado }}</td>
                    <td>
                        <a href="#" wire:click='edit({{ $farm->id }})' class="btn btn-sm btn-info"><i class="far fa-edit"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No hay registros</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $farms->links() }}
        </x-slot:cardFooter>
    </x-card>

    <x-modal modalId="modalFarm" modalTitle="Granja">
        <form wire:submit={{ $Id==0 ? "store" : "update($Id)" }}>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nombre</label>
                    <input type="text" class="form-control" wire:model="name" placeholder="Nombre de la granja">
                    @error('name') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>
                <div class="form-group col-md-6">
                    <label>Ubicación</label>
                    <input type="text" class="form-control" wire:model="location" placeholder="Ubicación">
                </div>
                <div class="form-group col-md-6">
                    <label>Responsable</label>
                    <input type="text" class="form-control" wire:model="owner" placeholder="Responsable">
                </div>
                <div class="form-group col-md-6">
                    <label>Estado</label>
                    <select class="form-control" wire:model="estado">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-success float-right">
                {{ $Id==0 ? "Guardar Granja" : "Editar Granja" }}
            </button>
        </form>
    </x-modal>
</div>
