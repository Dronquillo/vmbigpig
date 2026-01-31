<div>
    <x-card cardTitle='Chequeos de Bienestar ({{$checks->total()}})'>
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Nuevo Chequeo
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>Fecha</th>
                <th>Lote</th>
                <th>Cerdo</th>
                <th>Condición</th>
                <th>Severidad</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($checks as $check)
                <tr>
                    <td>{{ $check->date }}</td>
                    <td>{{ $check->lot->code ?? '-' }}</td>
                    <td>{{ $check->pig->codigo ?? '-' }}</td>
                    <td>{{ $check->condition }}</td>
                    <td>{{ ucfirst($check->severity) }}</td>
                    <td>
                        <a href="#" wire:click='edit({{ $check->id }})' class="btn btn-sm btn-info"><i class="far fa-edit"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No hay registros</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $checks->links() }}
        </x-slot:cardFooter>
    </x-card>

    @include('livewire.welfare.modal')
    
</div>
