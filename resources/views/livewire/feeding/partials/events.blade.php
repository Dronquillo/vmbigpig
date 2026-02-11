<x-table>
    <x-slot:thead>
        <th>Fecha</th><th>Notas</th><th>Estado</th>
    </x-slot>
    @foreach($events as $event)
        <tr>
            <td>{{ $event->date }}</td>
            <td>{{ $event->notes }}</td>
            <td>{{ $event->status }}</td>
        </tr>
    @endforeach
</x-table>
