<x-table>
    <x-slot:thead>
        <th>Tipo</th><th>Mensaje</th><th>Umbral</th><th>Estado</th>
    </x-slot>
    @foreach($alerts as $a)
        <tr>
            <td>{{ $a->type }}</td>
            <td>{{ $a->message }}</td>
            <td>{{ $a->threshold }}</td>
            <td>{{ $a->status }}</td>
        </tr>
    @endforeach
</x-table>
