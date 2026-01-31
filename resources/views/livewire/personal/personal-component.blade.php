<div>
    <x-card cardTitle="Gestión Personal ({{$this->totalRegistros}})">
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click="create">
                <i class="fas fa-plus-circle"></i> Crear Personal
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Cargo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($personals as $personal)
                <tr>
                    <td>{{$personal->id}}</td>
                    <td>{{$personal->nombre}}</td>
                    <td>{{$personal->apellido}}</td>
                    <td>{{$personal->email}}</td>
                    <td>{{$personal->categoria->nombre ?? '-'}}</td>
                    <td>{{$personal->estado}}</td>
                    <td>
                        <a href="#" wire:click="edit({{$personal->id}})" class="btn btn-sm btn-info"><i class="far fa-edit"></i></a>
                        <a wire:click="$dispatch('delete',{id: {{$personal->id}}, eventName:'destroyPersonal'})" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No hay registros</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{$personals->links()}}
        </x-slot:cardFooter>
    </x-card>

    <x-modal modalId="modalPersonal" modalTitle="Personal">
        <form wire:submit="{{$Id==0 ? 'store' : 'update('.$Id.')'}}">
            <div class="form-row">
                <div class="form-group col-6">
                    <label>Nombre</label>
                    <input wire:model="nombre" type="text" class="form-control">
                    @error('nombre') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>
                <div class="form-group col-6">
                    <label>Apellido</label>
                    <input wire:model="apellido" type="text" class="form-control">
                    @error('apellido') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>
                <div class="form-group col-6">
                    <label>Email</label>
                    <input wire:model="email" type="email" class="form-control">
                    @error('email') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>
                <div class="form-group col-6">
                    <label>Cargo</label>
                    <select wire:model="cargo_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach($categorias as $cat)
                            <option value="{{$cat->id}}">{{$cat->nombre}}</option>
                        @endforeach
                    </select>
                    @error('cargo_id') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                </div>
            </div>
            <button class="btn btn-primary float-right">{{$Id==0 ? 'Guardar' : 'Actualizar'}}</button>
        </form>
    </x-modal>
</div>
