<x-table>
    <x-slot:thead>
        <th>Fecha</th><th>Observaciones</th><th>Estado</th>
    </x-slot>
    @foreach($checks as $c)
        <tr>
            <td>{{ $c->date }}</td>
            <td>{{ $c->observations }}</td>
            <td>{{ $c->status }}</td>
        </tr>
    @endforeach
</x-table>
