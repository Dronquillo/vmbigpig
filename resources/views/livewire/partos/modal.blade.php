<x-modal modalId="modalParto" modalTitle="Registro de Parto" modalSize="modal-lg">
    <form wire:submit={{ $Id==0 ? "store" : "update($Id)" }}>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Fecha Parto</label>
                <input type="date" wire:model="fecha_parto" class="form-control">
                @error('fecha_parto') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>
            <div class="form-group col-md-6">
                <label>Hora Parto</label>
                <input type="time" wire:model="hora_parto" class="form-control">
                @error('hora_parto') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group col-md-4">
                <label>Activo (Madre)</label>
                <select wire:model="id_activo" class="form-control">
                    <option value="">-- Seleccione un cerdo --</option>
                    @foreach($activos as $activo)
                        <option value="{{ $activo->id }}">{{ $activo->codigo }}</option>
                    @endforeach
                </select>
                @error('id_activo') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group col-md-4">
                <label>Personal</label>
                <select wire:model="id_personal" class="form-control">
                    <option value="">-- Seleccione  --</option>
                    @foreach($personales as $p)
                        <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                    @endforeach
                </select>
                @error('id_personal') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group col-md-4">
                <label>Reproductor</label>
                <input type="text" wire:model="reproductor" class="form-control">
                @error('reproductor') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group col-md-4">
                <label>Número de Crías</label>
                <input type="number" wire:model="numero_crias" min="0" class="form-control">
                @error('numero_crias') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
                <small class="text-muted">Tras poner un número, usa “Añadir Cría” para cargar el detalle.</small>
            </div>

            <div class="form-group col-md-4">
                <label>Número de Camada (opcional)</label>
                <input type="number" wire:model="numero_camada" min="1" class="form-control">
                @error('numero_camada') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group col-md-4">
                <label>Galpón (Barn)</label>
                <select wire:model="barn_id" class="form-control">
                    <option value="">-- Seleccione un galpón --</option>
                    @foreach($barns as $barn)
                        <option value="{{ $barn->id }}">{{ $barn->name }}</option>
                    @endforeach
                </select>
                @error('barn_id') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group col-md-12">
                <label>Observaciones</label>
                <textarea wire:model="observaciones" class="form-control" rows="2"></textarea>
                @error('observaciones') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Detalle de Crías</h6>
                    <button type="button" class="btn btn-secondary btn-sm" wire:click="addEstado">Añadir Cría</button>
                </div>

                @forelse($estados as $index => $estado)
                    <div class="row align-items-center mb-2">
                        <div class="col-md-2">
                            <input type="text" class="form-control" value="Cría #{{ $estado['numero_camada'] }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" wire:model="estados.{{ $index }}.genero">
                                <option value="">-- Seleccione sexo --</option>
                                <option value="macho">Macho</option>
                                <option value="hembra">Hembra</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" wire:model="estados.{{ $index }}.estado">
                                <option value="">-- Seleccione el estado --</option>
                                <option value="vivo">Vivo</option>
                                <option value="muerto">Muerto</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Observaciones" wire:model="estados.{{ $index }}.observaciones">
                        </div>
                        <div class="col-md-1 text-right">
                            <button type="button" class="btn btn-danger btn-sm" wire:click="removeEstado({{ $index }})">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-light">Sin detalle aún. Añade crías con el botón.</div>
                @endforelse
            </div>
        </div>

        <button type="submit" class="btn btn-success float-right">{{ $Id==0 ? "Guardar" : "Editar" }}</button>
    </form>
</x-modal>

