<div>
    <x-card cardTitle='Eventos de Alimentación ({{$events->total()}})'>
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Nuevo Evento
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>Fecha</th>
                <th>Lote</th>
                <th>Cerdo</th>
                <th>Ración Objetivo (kg)</th>
                <th>Ración Real (kg)</th>
                <th>Desperdicio (kg)</th>
                <th>Costo (USD)</th>
                <th>Composición</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($events as $event)
                <tr>
                    <td>{{ $event->date->format('Y-m-d') }}</td>
                    <td>{{ $event->lot->code ?? '-' }}</td>
                    <td>{{ $event->pig->code ?? '-' }}</td>
                    <td>{{ $event->ration_target_kg }}</td>
                    <td>{{ $event->ration_actual_kg }}</td>
                    <td>{{ $event->waste_kg }}</td>
                    <td>{{ number_format($event->cost_usd,2) }}</td>
                    <td>{{ $event->composition }}</td>
                    <td>
                        <a href="#" wire:click='edit({{ $event->id }})' class="btn btn-sm btn-info">
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9">No hay registros</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $events->links() }}
        </x-slot:cardFooter>
    </x-card>

    @include('livewire.feeding.events.modal')
</div>
