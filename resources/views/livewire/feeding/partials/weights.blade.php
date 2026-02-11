<x-table>
    <x-slot:thead>
        <th>Fecha</th><th>Peso</th><th>Medida</th>
    </x-slot>
    @foreach($weights as $w)
        <tr>
            <td>{{ $w->date }}</td>
            <td>{{ $w->weight }}</td>
            <td>{{ optional($w->medida)->nombre }}</td>
        </tr>
    @endforeach
</x-table>
