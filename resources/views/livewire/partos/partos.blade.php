<div>
    <x-card cardTitle='Partos Registrados ({{$partos->total()}})'>
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Nuevo Parto
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>Fecha Parto</th>
                <th>Activo</th>
                <th>Personal</th>
                <th>Número Crías</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($partos as $parto)
                <tr>
                    <td>{{ $parto->fecha_parto?->format('Y-m-d') }}</td>
                    <td>{{ $parto->activo->codigo ?? '-' }}</td>
                    <td>{{ $parto->personal->nombre ?? '-' }}</td>
                    <td>{{ $parto->numero_crias }}</td>
                    <td>
                        <a href="{{ route('partos.show',$parto->id) }}" class="btn btn-sm btn-success"><i class="far fa-eye"></i></a>
                        <a href="#" wire:click='edit({{ $parto->id }})' class="btn btn-sm btn-info"><i class="far fa-edit"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No hay registros</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $partos->links() }}
        </x-slot:cardFooter>
    </x-card>

    @include('livewire.partos.modal')

</div>

