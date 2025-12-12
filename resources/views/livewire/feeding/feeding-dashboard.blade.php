<div>
    <x-card cardTitle="Registro de Alimentación">
        <x-slot:cardTools>
            <button wire:click="resetForm" class="btn btn-sm btn-secondary">
                <i class="fas fa-sync-alt"></i> Reset
            </button>
        </x-slot>

        <div class="row">
            <!-- Selección de lote -->
            <div class="form-group col-md-4">
                <label for="lot">Lote</label>
                <select wire:model="selectedLot" id="lot" class="form-control">
                    <option value="">Seleccione</option>
                    @foreach($lots as $lot)
                        <option value="{{$lot->id}}">{{$lot->code}} ({{$lot->current_count}} cerdos)</option>
                    @endforeach
                </select>
                @error('selectedLot') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Selección de cerdo -->
            <div class="form-group col-md-4">
                <label for="pig">Cerdo</label>
                <select wire:model="selectedPig" id="pig" class="form-control">
                    <option value="">Seleccione</option>
                    @foreach($pigs as $pig)
                        <option value="{{$pig->id}}">{{$pig->codigo}} - {{$pig->nombre}}</option>
                    @endforeach
                </select>
                @error('selectedPig') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Selección de producto -->
            <div class="form-group col-md-4">
                <label for="product">Producto</label>
                <select wire:model="selectedProduct" id="product" class="form-control">
                    <option value="">Seleccione</option>
                    @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->nombre}} (${{$product->precio}})</option>
                    @endforeach
                </select>
                @error('selectedProduct') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <!-- Cantidad -->
            <div class="form-group col-md-4">
                <label for="cantidad">Cantidad (kg)</label>
                <input type="number" step="0.001" wire:model="cantidad" id="cantidad" class="form-control">
                @error('cantidad') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <!-- Costo calculado -->
            <div class="form-group col-md-4">
                <label for="costo">Costo (USD)</label>
                <input type="text" wire:model="costo" id="costo" class="form-control" readonly>
            </div>

            <!-- Desperdicio -->
            <div class="form-group col-md-4">
                <label for="waste">Desperdicio (kg)</label>
                <input type="number" step="0.001" wire:model="wasteKg" id="waste" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12 text-right">
                <button wire:click="save" class="btn btn-primary">
                    <i class="fas fa-save"></i> Registrar Alimentación
                </button>
            </div>
        </div>
    </x-card>

    <!-- Historial -->
    <x-card cardTitle="Historial de Alimentación">
        <x-table>
            <x-slot:thead>
                <th>Fecha</th>
                <th>Lote</th>
                <th>Cerdo</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Costo</th>
            </x-slot>
            @forelse($events as $event)
                <tr>
                    <td>{{$event->date}}</td>
                    <td>{{$event->lot?->code}}</td>
                    <td>{{$event->pig?->codigo}}</td>
                    <td>{{json_decode($event->composition)[0]['producto'] ?? 'N/A'}}</td>
                    <td>{{$event->ration_actual_kg}} kg</td>
                    <td>${{$event->cost_usd}}</td>
                </tr>
            @empty
                <tr><td colspan="6">No hay registros</td></tr>
            @endforelse
        </x-table>
    </x-card>
</div>
