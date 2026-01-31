{{-- resources/views/livewire/welfare/modal.blade.php --}}
<x-modal modalId="modalWelfare" modalTitle="Chequeo de Bienestar" modalSize="modal-lg">
    <form wire:submit={{ $Id==0 ? "store" : "update($Id)" }}>

        <div class="form-row">
            {{-- Fecha --}}
            <div class="form-group col-md-4">
                <label for="date">Fecha</label>
                <input type="date" id="date" wire:model="date" class="form-control">
                @error('date')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Lote (opcional) --}}
            <div class="form-group col-md-4">
                <label for="lot_id">Lote (opcional)</label>
                <select id="lot_id" wire:model="lot_id" class="form-control">
                    <option value="">-- Seleccione un lote --</option>
                    @foreach($lots as $lot)
                        <option value="{{ $lot->id }}">{{ $lot->code }}</option>
                    @endforeach
                </select>
                @error('lot_id')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Cerdo (opcional) --}}
            <div class="form-group col-md-4">
                <label for="pig_id">Cerdo (opcional)</label>
                <select id="pig_id" wire:model="pig_id" class="form-control">
                    <option value="">-- Seleccione un cerdo --</option>
                    @foreach($pigs as $pig)
                        <option value="{{ $pig->id }}">{{ $pig->codigo }}</option>
                    @endforeach
                </select>
                @error('pig_id')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Condición --}}
            <div class="form-group col-md-6">
                <label for="condition">Condición</label>
                <input type="text" id="condition" wire:model="condition" class="form-control" placeholder="Ej. cojera, heridas, falta de apetito">
                @error('condition')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Severidad --}}
            <div class="form-group col-md-6">
                <label for="severity">Severidad</label>
                <select id="severity" wire:model="severity" class="form-control">
                    <option value="">-- Seleccione --</option>
                    <option value="low">Baja</option>
                    <option value="medium">Media</option>
                    <option value="high">Alta</option>
                </select>
                @error('severity')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Notas --}}
            <div class="form-group col-md-12">
                <label for="notes">Notas</label>
                <textarea id="notes" wire:model="notes" class="form-control" rows="3" placeholder="Observaciones adicionales, tratamientos aplicados, recomendaciones"></textarea>
                @error('notes')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Veterinario requerido --}}
            <div class="form-group col-md-12">
                <div class="form-check">
                    <input type="checkbox" id="vet_required" wire:model="vet_required" class="form-check-input">
                    <label for="vet_required" class="form-check-label">Requiere evaluación veterinaria</label>
                </div>
                @error('vet_required')
                    <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Ayuda visual rápida --}}
        <div class="card mb-3">
            <div class="card-header bg-light">
                Resumen
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-3">
                    <span class="badge badge-secondary">Fecha: {{ $date }}</span>
                    <span class="badge badge-info">Lote: {{ optional(collect($lots)->firstWhere('id',$lot_id))->code ?? '-' }}</span>
                    <span class="badge badge-primary">Cerdo: {{ optional(collect($pigs)->firstWhere('id',$pig_id))->code ?? '-' }}</span>
                    <span class="badge badge-warning">Severidad: {{ $severity ? ucfirst($severity) : '-' }}</span>
                    <span class="badge badge-success">Veterinario: {{ $vet_required ? 'Sí' : 'No' }}</span>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success float-right">{{ $Id==0 ? "Guardar Chequeo" : "Editar Chequeo" }}</button>
    </form>
</x-modal>
