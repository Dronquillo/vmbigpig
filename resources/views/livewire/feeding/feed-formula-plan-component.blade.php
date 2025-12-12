<div>
    <x-card cardTitle="Formulaciones de Alimentación ({{$this->totalRegistros}})">
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click="$dispatch('openFormulaModal')">
                <i class="fas fa-plus-circle"></i> Crear Fórmula
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Composición</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($formulas as $formula)
                <tr>
                    <td>{{$formula->id}}</td>
                    <td>{{$formula->name}}</td>
                    <td>
                        @foreach($formula->items as $item)
                            {{$item->feedItem->name}} ({{$item->percentage}}%)<br>
                        @endforeach
                    </td>
                    <td>
                        <a href="#" wire:click="$dispatch('editFormula', {id: {{$formula->id}}})" class="btn btn-sm btn-info">
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No hay fórmulas</td></tr>
            @endforelse
        </x-table>
        <x-slot:cardFooter>{{$formulas->links()}}</x-slot:cardFooter>
    </x-card>

    <x-card cardTitle="Planes de Alimentación">
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click="$dispatch('openPlanModal')">
                <i class="fas fa-plus-circle"></i> Crear Plan
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Lote</th>
                <th>Fórmula</th>
                <th>Días</th>
                <th>Ración/Pig</th>
            </x-slot>
            @forelse($plans as $plan)
                <tr>
                    <td>{{$plan->id}}</td>
                    <td>{{$plan->lot->code}}</td>
                    <td>{{$plan->feedFormula->name}}</td>
                    <td>{{$plan->day_from}} - {{$plan->day_to}}</td>
                    <td>{{$plan->ration_per_pig_kg}} kg</td>
                </tr>
            @empty
                <tr><td colspan="5">No hay planes</td></tr>
            @endforelse
        </x-table>
        <x-slot:cardFooter>{{$plans->links()}}</x-slot:cardFooter>
    </x-card>
</div>

