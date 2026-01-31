<div>
    <x-card cardTitle="Gestión Categorías de Personal ({{$this->totalRegistros}})">
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click="create">
                <i class="fas fa-plus-circle"></i> Crear Categoría
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($categorias as $cat)
                <tr>
                    <td>{{$cat->id}}</td>
                    <td>{{$cat->nombre}}</td>
                    <td>
                        <a href="#" wire:click="edit({{$cat->id}})" class="btn btn-sm btn-info"><i class="far fa-edit"></i></a>
                        <a wire:click="$dispatch('delete',{id: {{$cat->id}}, eventName:'destroyCategoriaPersonal'})" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">No hay registros</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{$categorias->links()}}
        </x-slot:cardFooter>
    </x-card>

    <x-modal modalId="modalCategoriaPersonal" modalTitle="Categoría de Personal">
        <form wire:submit="{{$Id==0 ? 'store' : 'update('.$Id.')'}}">
            <div class="form-group">
                <label>Nombre</label>
                <input wire:model="nombre" type="text" class="form-control" placeholder="Nombre de la categoría">
                @error('nombre') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>
            <button class="btn btn-primary float-right">{{$Id==0 ? 'Guardar' : 'Actualizar'}}</button>
        </form>
    </x-modal>
</div>
