<div>
    <x-card cardTitle="Gestión Lotes Engorde ({{$this->totalRegistros}})">
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click="$dispatch('openLotModal')">
                <i class="fas fa-plus-circle"></i> Crear Lote
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Código</th>
                <th>Corral</th>
                <th>Cantidad Actual</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($lots as $lot)
                <tr>
                    <td>{{$lot->id}}</td>
                    <td>{{$lot->code}}</td>
                    <td>{{$lot->barn->name}}</td>
                    <td>{{$lot->current_count}}</td>
                    <td>
                        <a href="{{route('growth.weights',$lot->id)}}" class="btn btn-sm btn-success" title="Pesajes">
                            <i class="fas fa-weight"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No hay lotes registrados</td></tr>
            @endforelse
        </x-table>

        <x-slot:cardFooter>
            {{$lots->links()}}
        </x-slot:cardFooter>
    </x-card>
</div>

