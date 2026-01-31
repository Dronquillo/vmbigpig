<div>
    <x-card cardTitle="Alertas">
        <x-slot:cardTools>
            <button wire:click="limpiarFiltros" class="btn btn-sm btn-secondary">
                <i class="fas fa-eraser"></i> Limpiar
            </button>
        </x-slot>

        <!-- Métricas -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $total }}</h3>
                        <p>Total de Alertas</p>
                    </div>
                    <div class="icon"><i class="fas fa-bell"></i></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $criticas }}</h3>
                        <p>Críticas Pendientes</p>
                    </div>
                    <div class="icon"><i class="fas fa-exclamation-circle"></i></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $pendientes }}</h3>
                        <p>Alertas Pendientes</p>
                    </div>
                    <div class="icon"><i class="fas fa-hourglass-half"></i></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $resueltas }}</h3>
                        <p>Alertas Resueltas</p>
                    </div>
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Buscar..." wire:model.debounce.500ms="search">
            </div>
            <div class="col-md-3">
                <select class="form-control" wire:model="type">
                    <option value="">Tipo</option>
                    <option value="stock_low">Stock bajo</option>
                    <option value="weight_stall">Estancamiento de peso</option>
                    <option value="welfare_high">Incidencia bienestar</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" wire:model="level">
                    <option value="">Nivel</option>
                    <option value="info">Info</option>
                    <option value="warning">Warning</option>
                    <option value="critical">Critical</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" wire:model="resolved">
                    <option value="">Estado</option>
                    <option value="0">Pendientes</option>
                    <option value="1">Resueltas</option>
                </select>
            </div>
        </div>

        <!-- Tabla -->
        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Tipo</th>
                <th>Nivel</th>
                <th>Objeto</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Datos</th>
                <th>Acciones</th>
            </x-slot>
            @forelse($alerts as $alert)
                <tr>
                    <td>{{ $alert->id }}</td>
                    <td>{{ $alert->type }}</td>
                    <td>
                        <span class="badge badge-{{ $alert->level === 'critical' ? 'danger' : ($alert->level === 'warning' ? 'warning' : 'info') }}">
                            {{ $alert->level }}
                        </span>
                    </td>
                    <td>{{ class_basename($alert->alertable_type) }} #{{ $alert->alertable_id }}</td>
                    <td>
                        <span class="badge badge-{{ $alert->resolved ? 'success' : 'warning' }}">
                            {{ $alert->resolved ? 'Resuelta' : 'Pendiente' }}
                        </span>
                    </td>
                    <td>{{ $alert->created_at?->toDateTimeString() }}</td>
                    <td>{{ is_array($alert->data) ? json_encode($alert->data) : $alert->data }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" wire:click="verDetalle({{ $alert->id }})">
                            <i class="far fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-{{ $alert->resolved ? 'secondary' : 'success' }}"
                                wire:click="toggleResolved({{ $alert->id }})">
                            <i class="fas fa-check"></i> {{ $alert->resolved ? 'Restaurar' : 'Resolver' }}
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">No hay alertas</td></tr>
            @endforelse
        </x-table>

        <div class="mt-3">
            {{ $alerts->links() }}
        </div>
    </x-card>

    <!-- Modal detalle -->
    <x-modal id="modalAlertDetail" title="Detalle de alerta" size="
