<h2>Reporte de Alimentación</h2>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Lote</th>
            <th>Cerdo</th>
            <th>Producto</th>
            <th>Cantidad (kg)</th>
            <th>Costo (USD)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($events as $event)
            @php $composition = json_decode($event->composition, true); @endphp
            <tr>
                <td>{{$event->date}}</td>
                <td>{{$event->lot?->code}}</td>
                <td>{{$event->pig?->codigo}}</td>
                <td>{{$composition[0]['producto'] ?? 'N/A'}}</td>
                <td>{{$event->ration_actual_kg}}</td>
                <td>${{$event->cost_usd}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
