<x-table>
    <x-slot:thead>
        <th>Nombre</th><th>Inicio</th><th>Estado</th>
    </x-slot>
    @foreach($plans as $plan)
        <tr>
            <td>{{ $plan->name }}</td>
            <td>{{ $plan->start_date }}</td>
            <td>{{ $plan->status }}</td>
        </tr>
    @endforeach
</x-table>
