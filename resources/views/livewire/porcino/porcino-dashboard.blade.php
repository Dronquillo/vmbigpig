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
                        <h3>{{$lotsActivos}}</h3>
                        <p>Lotes Activos</p>
                    </div>
                    <div class="icon"><i class="fas fa-piggy-bank"></i></div>
                </div>
            </div>

            <!-- Stock total -->
            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{number_format($stockTotal,2)}} kg</h3>
                        <p>Stock Alimentos</p>
                    </div>
                    <div class="icon"><i class="fas fa-warehouse"></i></div>
                </div>
            </div>

            <!-- ADG promedio -->
            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{number_format($adgPromedio,3)}} kg/día</h3>
                        <p>ADG Promedio</p>
                    </div>
                    <div class="icon"><i class="fas fa-weight"></i></div>
                </div>
            </div>

            <!-- Alertas críticas -->
            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$alertasCriticas}}</h3>
                        <p>Alertas Críticas</p>
                    </div>
                    <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                </div>
            </div>
        </div>
    </x-card>

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
                    <td>{{$alerta->id}}</td>
                    <td>{{$alerta->type}}</td>
                    <td>
                        <span class="badge badge-{{$alerta->level == 'critical' ? 'danger' : 'warning'}}">
                            {{$alerta->level}}
                        </span>
                    </td>
                    <td>{{$alerta->created_at->toDateTimeString()}}</td>
                    <td>{{json_encode($alerta->data)}}</td>
                </tr>
            @empty
                <tr><td colspan="5">No hay alertas pendientes</td></tr>
            @endforelse
        </x-table>
    </x-card>
</div>

