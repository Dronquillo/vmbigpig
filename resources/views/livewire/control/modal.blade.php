<x-modal modalId="modalControl" modalTitle="Registrar Actividad" modalSize="modal-lg">
    <form wire:submit.prevent="store">
        <div class="form-row">
            <!-- Campos comunes -->
            <div class="form-group col-md-4">
                <label>Lote</label>
                <select wire:model="lot_id" class="form-control">
                    <option value="">-- Seleccione Lote --</option>
                    @foreach($lots as $lot)
                        <option value="{{ $lot->id }}">{{ $lot->code }}</option>
                    @endforeach
                </select>
            </div>

            
             <div class="form-group col-md-4">
                <label>Animal</label>
                <select wire:model="activovivo_id" class="form-control">
                    <option value="">-- Seleccione Animal --</option>
                    @foreach($animals as $animal)
                        <option value="{{ $animal->id }}">{{ $animal->codigo }} - {{ $animal->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>Empresa Responsable</label>
                <select wire:model="empresa_id" class="form-control">
                    <option value="">-- Seleccione Empresa --</option>
                    @foreach($empresas as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-3">
                <label>Fecha</label>
                <input type="date" wire:model="fecha" class="form-control">
            </div>
            <div class="form-group col-md-3">
                <label>Hora</label>
                <input type="time" wire:model="hora" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label>Descripción</label>
                <textarea wire:model="descripcion" class="form-control"></textarea>
            </div>
        </div>

        @if($tipo === 'chequeo')
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Tipo de Inseminación</label>
                    <select wire:model="tipo_inseminacion" class="form-control">
                        <option value="">-- Seleccione Tipo --</option>
                        <option value="Inseminación Artificial">Inseminación Artificial</option>
                        <option value="Monta Natural">Monta Natural</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>Fecha de Preñez</label>
                    <input type="date" wire:model="fecha_preñez" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>Macho Asociado</label>
                    <select wire:model="macho_id" class="form-control">
                        <option value="">-- Seleccione Macho --</option>
                        @foreach($animals as $animal)
                            @if($animal->genero === 'Macho')
                                <option value="{{ $animal->id }}">{{ $animal->codigo }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        @endif       

        <!-- Alimentación -->
        @if($tipo === 'alimentacion')
            <div class="card mb-4">
                <div class="card-header bg-info text-white">Detalle de Alimentación</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col">
                            <label>Producto</label>
                            <select wire:model="producto_id" class="form-control" >
                                <option value="">-- Seleccione Producto --</option>
                                @foreach($productos as $prod)
                                    <option value="{{ $prod->id }}">
                                        {{ $prod->nombre }} (Stock: {{ $prod->stock }}) - Precio: ${{ $prod->costo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label>Cantidad (kg)</label>
                            <input type="number" wire:model="cantidad" class="form-control">
                        </div>
                        <div class="col">
                            <button type="button" wire:click="addDetalle" class="btn btn-primary mt-4">Agregar</button>
                        </div>
                    </div>

                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalles as $index => $d)
                                <tr>
                                    <td>{{ is_array($d) ? ($d['nombre'] ?? '') : ($d->producto->nombre ?? '') }}</td>
                                    <td>{{ is_array($d) ? $d['cantidad'] : $d->cantidad }}</td>
                                    <td>${{ number_format(is_array($d) ? $d['precio'] : $d->precio,2) }}</td>
                                    <td>${{ number_format(is_array($d) ? $d['subtotal'] : $d->subtotal,2) }}</td>
                                    <td>
                                        <button type="button" wire:click="removeDetalle({{ $index }})" class="btn btn-danger btn-sm">Eliminar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <!-- Fin Alimentación -->
        <!-- Mostrar animales vivos para alimentación -->
        @if($tipo === 'alimentacion' && $lot_id)
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">Cerdos vivos en el lote seleccionado</div>
                <div class="card-body">
                    @if(count($animals) > 0)
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Género</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($animals as $animal)
                                    <tr>
                                        <td>{{ $animal->codigo }}</td>
                                        <td>{{ $animal->nombre }}</td>
                                        <td>{{ ucfirst($animal->genero) }}</td>
                                        <td>{{ $animal->estado }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay cerdos vivos en este lote.</p>
                    @endif
                </div>
            </div>
        @endif


        <!-- Chequeo Médico -->
        @if($tipo === 'chequeo')
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">Chequeo Médico</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col">
                            <label>Veterinario</label>
                            <select wire:model="veterinario_id" class="form-control">
                                @foreach($veterinarios as $vet)
                                    <option value="{{ $vet->id }}">{{ $vet->nombre }} {{ $vet->apellido }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label>Costo Veterinario</label>
                            <input type="number" step="0.01" wire:model="veterinario_costo" class="form-control">
                        </div>
                        <div class="col">
                            <label>Fecha Inseminación/Monta</label>
                            <input type="date" wire:model="inseminacion_fecha" class="form-control">
                        </div>
                        <div class="col">
                            <label>Comentario</label>
                            <textarea wire:model="comentario" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Parto -->
        @if($tipo === 'parto')
            <div class="card mb-4">
                <div class="card-header bg-success text-white">Registrar Parto</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col">
                            <label>Código nuevo lote</label>
                            <input type="text" wire:model="nuevo_lote_code" class="form-control">
                        </div>
                        <div class="col">
                            <label>Número de cerdos nacidos</label>
                            <input type="number" wire:model="num_cerdos" class="form-control">
                        </div>
                        <div class="col">
                            <label>Veterinario</label>
                            <select wire:model="veterinario_id" class="form-control">
                                @foreach($veterinarios as $vet)
                                    <option value="{{ $vet->id }}">{{ $vet->nombre }} {{ $vet->apellido }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="col">
                            <label>Comentario</label>
                            <textarea wire:model="comentario" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <button type="submit" class="btn btn-success float-right">Guardar Actividad</button>
        
    </form>
</x-modal>
