<x-table>
    <x-slot:thead>
        <th>Código</th><th>Nombre</th><th>Peso</th><th>Estado</th>
    </x-slot>
    @foreach($animals as $a)
        <tr>
            <td>{{ $a->codigo }}</td>
            <td>{{ $a->nombre }}</td>
            <td>{{ $a->peso }}</td>
            <td>{{ $a->estado_salud }}</td>
        </tr>
    @endforeach
</x-table>
