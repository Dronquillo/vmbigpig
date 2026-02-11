<x-table>
    <x-slot:thead>
        <th>Fecha</th><th>Tamaño Camada</th><th>Notas</th>
    </x-slot>
    @foreach($births as $b)
        <tr>
            <td>{{ $b->date }}</td>
            <td>{{ $b->litter_size }}</td>
            <td>{{ $b->notes }}</td>
        </tr>
    @endforeach
</x-table>
