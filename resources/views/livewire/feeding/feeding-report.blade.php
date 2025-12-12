<div>
    <x-card cardTitle="Reporte de Alimentación por Lote y Cerdo">
        <x-slot:cardTools>
            <button wire:click="exportPDF" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf"></i> PDF
            </button>
            <button wire:click="exportExcel" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Excel
            </button>
            <button wire:click="exportCSV" class="btn btn-info btn-sm">
                <i class="fas fa-file-csv"></i> CSV
            </button>
        </x-slot>

        <!-- Filtros -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="lot">Lote</label>
                <select wire:model="selectedLot" id="lot" class="form-control">
                    <option value="">Todos</option>
                    @foreach($lots as $lot)
                        <option value="{{$lot->id}}">{{$lot->code}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="startDate">Fecha inicio</label>
                <input type="date" wire:model="startDate" id="startDate" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="endDate">Fecha fin</label>
                <input type="date" wire:model="endDate" id="endDate" class="form-control">
            </div>
        </div>

        <!-- Tabla -->
        <x-table>
            <x-slot:thead>
                <th>Fecha</th>
                <th>Lote</th>
                <th>Cerdo</th>
                <th>Producto</th>
                <th>Cantidad (kg)</th>
                <th>Costo (USD)</th>
            </x-slot>
            @forelse($events as $event)
                @php $composition = json_decode($event->composition, true); @endphp
                <tr>
                    <td>{{$event->date}}</td>
                    <td>{{$event->lot?->code}}</td>
                    <td>{{$event->pig?->codigo}}</td>
                    <td>{{$composition[0]['producto'] ?? 'N/A'}}</td>
                    <td>{{$event->ration_actual_kg}}</td>
                    <td>${{$event->cost_usd}}</td>
                </tr>
            @empty
                <tr><td colspan="6">No hay registros</td></tr>
            @endforelse
        </x-table>
    </x-card>
</div>


