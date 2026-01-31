<div>
    <x-card cardTitle='Registros de Peso ({{$records->total()}})'>
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Nuevo Registro
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>Fecha</th>
                <th>Lote</th>
                <th>Cerdo</th>
                <th>Peso (kg)</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($records as $record)
                <tr>
                    <td>{{ $record->date }}</td>
                    <td>{{ $record->lot->code ?? '-' }}</td>
                    <td>{{ $record->pig->codigo ?? '-' }}</td>
                    <td>{{ $record->weight_kg }}</td>
                    <td>
                        <a href="#" wire:click='edit({{ $record->id }})' class="btn btn-sm btn-info"><i class="far fa-edit"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No hay registros</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $records->links() }}
        </x-slot:cardFooter>
    </x-card>

    @include('livewire.growth.weights.modal')
    
</div>
