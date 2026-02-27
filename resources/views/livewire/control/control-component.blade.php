<div>
    <x-card cardTitle='Control de Actividades ({{$controles->total()}})'>
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create("alimentacion")'>
                <i class="fas fa-plus-circle"></i> Registrar Alimentación
            </a>
            <a href="#" class="btn btn-info" wire:click='create("chequeo")'>
                <i class="fas fa-plus-circle"></i> Chequeo Médico
            </a>
            <a href="#" class="btn btn-success" wire:click='create("parto")'>
                <i class="fas fa-plus-circle"></i> Registrar Parto
            </a>            
        </x-slot:cardTools>

        <x-table>
            <x-slot:thead>
                <th>#</th>
                <th>Lote</th>
                <th>Animal</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Costo</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </x-slot:thead>
            @forelse($controles as $ctrl)
                <tr>
                    <td>{{ $ctrl->id }}</td>
                    <td>{{ $ctrl->lot->code }}</td>
                    <td>{{ $ctrl->animal?->codigo ?? '—' }}</td>
                    <td>{{ ucfirst($ctrl->tipo) }}</td>
                    <td>{{ $ctrl->descripcion }}</td>
                    <td>{{ $ctrl->costo }}</td>
                    <td>{{ $ctrl->fecha }}</td>
                    <td>
                        <a href="#" wire:click='edit({{$ctrl->id}})' class="btn btn-sm btn-info" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="#" wire:click='showDetalles({{$ctrl->id}})' class="btn btn-sm btn-secondary" title="Detalles">
                            <i class="far fa-eye"></i>
                        </a>

                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No hay registros</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{$controles->links()}}
        </x-slot:cardFooter>
    </x-card>

    @include('livewire.control.modal')
    @include('livewire.control.modal-Detalles')


</div>
