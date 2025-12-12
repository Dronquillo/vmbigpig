<div>
    <x-card cardTitle="Gestión Lotes ({{$lots->total()}})">
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click="create">
                <i class="fas fa-plus-circle"></i> Crear Lote
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>Id</th>
                <th>Código</th>
                <th>Corral</th>
                <th>Fecha inicio</th>
                <th>Inicial</th>
                <th>Actual</th>
                <th>Estado</th>
                <th>Acciones</th>
            </x-slot>

            @forelse($lots as $lot)
                <tr>
                    <td>{{$lot->id}}</td>
                    <td>{{$lot->code}}</td>
                    <td>{{$lot->barn?->name}}</td>
                    <td>{{$lot->start_date?->toDateString()}}</td>
                    <td>{{$lot->initial_count}}</td>
                    <td>{{$lot->current_count}}</td>
                    <td>
                        @if($lot->end_date)
                            <span class="badge badge-secondary">Cerrado</span>
                        @else
                            <span class="badge badge-success">Activo</span>
                        @endif
                    </td>
                    <td class="whitespace-nowrap">
                        <a href="{{route('growth.weights',$lot->id)}}" class="btn btn-sm btn-warning" title="Pesajes (Engorde)">
                            <i class="fas fa-weight"></i>
                        </a>
                        <a href="{{route('farms.show',$lot)}}" class="btn btn-sm btn-success" title="Ver">
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="#" wire:click="edit({{$lot->id}})" class="btn btn-sm btn-info" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="#" wire:click="$dispatch('delete',{id: {{$lot->id}}, eventName:'destroyLot'})" class="btn btn-sm btn-danger" title="Eliminar">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay lotes registrados</td>
                </tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{$lots->links()}}
        </x-slot:cardFooter>
    </x-card>

    {{-- Modal crear/editar lote --}}
    <x-modal modalId="modalLot" modalTitle="{{$Id==0 ? 'Crear Lote' : 'Editar Lote'}}">
        <form wire:submit.prevent="{{$Id==0 ? 'store' : 'update('.$Id.')'}}">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="code">Código</label>
                    <input wire:model.defer="code" type="text" class="form-control" id="code" placeholder="Código de lote">
                    @error('code')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="barn_id">Corral</label>
                    <select wire:model.defer="barn_id" id="barn_id" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach($barns as $barn)
                            <option value="{{$barn->id}}">{{$barn->name}}</option>
                        @endforeach
                    </select>
                    @error('barn_id')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="start_date">Fecha inicio</label>
                    <input wire:model.defer="start_date" type="date" class="form-control" id="start_date">
                    @error('start_date')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="initial_count">Cantidad inicial</label>
                    <input wire:model.defer="initial_count" type="number" min="1" class="form-control" id="initial_count" placeholder="Ej. 50">
                    @error('initial_count')
                        <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button class="btn btn-primary float-right">
                {{$Id==0 ? 'Guardar Lote' : 'Actualizar Lote'}}
            </button>
        </form>
    </x-modal>
</div>


