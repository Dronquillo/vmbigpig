<div>
    <x-card cardTitle="Dashboard Gestión Porcina">
        <x-slot:cardTools>
            <button wire:click="cargarMétricas" class="btn btn-sm btn-primary">
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
        </x-slot>

        <div class="row">
            <!-- Lotes activos -->
            <div class="col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $lotsActivos }}</h3>
                        <p>Lotes Activos</p>
                    </div>
                    <div class="icon"><i class="fas fa-piggy-bank"></i></div>
                </div>
            </div>

            <!-- Animales vivos -->
            <div class="col-md-3">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $animalesVivos }}</h3>
                        <p>Animales Vivos</p>
                    </div>
                    <div class="icon"><i class="fas fa-dna"></i></div>
                </div>
            </div>

            <!-- Stock total -->
            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ number_format($stockTotal, 2) }} kg</h3>
                        <p>Stock Alimentos</p>
                    </div>
                    <div class="icon"><i class="fas fa-warehouse"></i></div>
                </div>
            </div>

            <!-- ADG promedio -->
            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($adgPromedio, 3) }} kg/día</h3>
                        <p>ADG Promedio</p>
                    </div>
                    <div class="icon"><i class="fas fa-weight"></i></div>
                </div>
            </div>

            <!-- Alertas críticas -->
            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $alertasCriticas }}</h3>
                        <p>Alertas Críticas</p>
                    </div>
                    <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                </div>
            </div>
        </div>
    </x-card>

    <!-- Últimas Alertas -->
    <x-card cardTitle="Últimas Alertas Pendientes">
        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Tipo</th>
                <th>Nivel</th>
                <th>Fecha</th>
                <th>Datos</th>
            </x-slot>
            @forelse($alertasPendientes as $alerta)
                <tr>
                    <td>{{ $alerta->id }}</td>
                    <td>{{ $alerta->type }}</td>
                    <td>
                        <span class="badge badge-{{ $alerta->level === 'critical' ? 'danger' : 'warning' }}">
                            {{ $alerta->level }}
                        </span>
                    </td>
                    <td>{{ $alerta->created_at->toDateTimeString() }}</td>
                    <td>{{ is_array($alerta->data) ? json_encode($alerta->data) : $alerta->data }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No hay alertas pendientes</td></tr>
            @endforelse
        </x-table>
    </x-card>

    <!-- Últimos eventos de alimentación -->
    <x-card cardTitle="Últimos Eventos de Alimentación">
        <x-table>
            <x-slot:thead>
                <th>Lote</th>
                <th>Fecha</th>
                <th>Alimento</th>
                <th>Cantidad</th>
            </x-slot>
            @forelse($ultimoFeedingEvents as $event)
                <tr>
                    <td>{{ $event->lot_id }}</td>
                    <td>{{ $event->created_at?->toDateTimeString() }}</td>
                    <td>{{ $event->composition }}</td>
                    <td>{{ number_format($event->ration_actual_kg, 2) }} kg</td>
                </tr>
            @empty
                <tr><td colspan="4">No hay eventos recientes</td></tr>
            @endforelse
        </x-table>
    </x-card>

    <!-- Últimos registros de peso -->
    <x-card cardTitle="Últimos Registros de Peso">
        <x-table>
            <x-slot:thead>
                <th>Activo</th>
                <th>Fecha</th>
                <th>Peso</th>
            </x-slot>
            @forelse($ultimoPesajes as $peso)
                <tr>
                    <td>{{ $peso->pig_id }}</td>
                    <td>{{ $peso->created_at?->toDateTimeString() }}</td>
                    <td>{{ number_format($peso->weight_kg, 2) }} kg</td>
                </tr>
            @empty
                <tr><td colspan="3">No hay registros recientes</td></tr>
            @endforelse
        </x-table>
    </x-card>

    <!-- Últimos chequeos de bienestar -->
    <x-card cardTitle="Últimos Chequeos de Bienestar">
        <x-table>
            <x-slot:thead>
                <th>Activo</th>
                <th>Fecha</th>
                <th>Estado</th>
            </x-slot>
            @forelse($ultimoWelfareChecks as $check)
                <tr>
                    <td>{{ $check->pig_id }}</td>
                    <td>{{ $check->created_at?->toDateTimeString() }}</td>
                    <td>{{ $check->notes }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No hay chequeos recientes</td></tr>
            @endforelse
        </x-table>
    </x-card>
</div>
