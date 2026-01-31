<div>
    <x-card cardTitle="Detalle del Parto #{{ $parto->id }}">
        <x-slot:cardTools>
            <a href="{{ route('partos') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>  Volver 
            </a>
        </x-slot>

        <div class="row">
            <div class="col-md-6">
                <p><strong>Fecha Parto:</strong> {{ $parto->fecha_parto?->format('Y-m-d') }}</p>
                <p><strong>Hora Parto:</strong> {{ $parto->hora_parto }}</p>
                <p><strong>Activo (Madre):</strong> {{ $parto->activo->codigo ?? '-' }}</p>
                <p><strong>Personal:</strong> {{ $parto->personal->nombre ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Número de Camada:</strong> {{ $parto->numero_camada }}</p>
                <p><strong>Número de Crías:</strong> {{ $parto->numero_crias }}</p>
                <p><strong>Reproductor:</strong> {{ $parto->reproductor }}</p>
                <p><strong>Observaciones:</strong> {{ $parto->observaciones }}</p>
            </div>
        </div>

        <hr>

        <h5>Detalle de Crías</h5>
        <x-table>
            <x-slot:thead>
                <th>#</th>
                <th>Género</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </x-slot>
            @forelse($parto->estados as $estado)
                <tr>
                    <td>{{ $estado->numero_camada }}</td>
                    <td>{{ $estado->genero }}</td>
                    <td>{{ $estado->estado }}</td>
                    <td>{{ $estado->observaciones }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No hay crías registradas</td></tr>
            @endforelse
        </x-table>
    </x-card>
</div>
