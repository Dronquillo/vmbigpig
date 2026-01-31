<div>
    <x-card cardTitle='Planes de Alimentación ({{$plans->total()}})'>
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Nuevo Plan
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>Lote</th>
                <th>Fórmula</th>
                <th>Día Desde</th>
                <th>Día Hasta</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($plans as $plan)
                <tr>
                    <td>{{ $plan->lot->code ?? '-' }}</td>
                    <td>{{ $plan->formula->name ?? '-' }}</td>
                    <td>{{ $plan->day_from }}</td>
                    <td>{{ $plan->day_to }}</td>
                    <td>{{ $plan->ration_per_pig_kg }}</td>
                    <td>
                        <a href="#" wire:click='edit({{ $plan->id }})' class="btn btn-sm btn-info"><i class="far fa-edit"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No hay registros</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{ $plans->links() }}
        </x-slot:cardFooter>
    </x-card>

    @include('livewire.feeding.plans.modal')
    
</div>
