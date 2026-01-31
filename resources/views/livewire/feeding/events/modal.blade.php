<x-modal modalId="modalFeeding" modalTitle="Evento de Alimentación" modalSize="modal-lg">
    <form wire:submit={{ $Id==0 ? "store" : "update($Id)" }}>
        <div class="form-row">

            <div class="form-group col-md-6">
                <label>Fecha</label>
                <input type="date" wire:model="date" class="form-control">
                @error('date') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group col-md-6">
                <label>Lote</label>
                <select wire:model="lot_id" class="form-control">
                    <option value="">-- Seleccione un lote --</option>
                    @foreach($lots as $lot)
                        <option value="{{ $lot->id }}">{{ $lot->code }}</option>
                    @endforeach
                </select>
                @error('lot_id') <div class="alert alert-danger mt-2">{{ $message }}</div> @enderror
            </div>

            <div class="form-group col-md-6">
                <label>Cerdo</label>
                <select wire:model="pig_id" class="form-control">
                    <option value="">-- Seleccione un Cerdo --</option>
                    @foreach($pigs as $pig)
                        <option value="{{ $pig->id }}">{{ $pig->codigo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label>Ración Objetivo (kg)</label>
                <input type="number" wire:model="ration_target_kg" step="0.01" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label>Ración Real (kg)</label>
                <input type="number" wire:model="ration_actual_kg" step="0.01" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label>Desperdicio (kg)</label>
                <input type="number" wire:model="waste_kg" step="0.01" class="form-control">
            </div>

            <div class="form-group col-md-6">
                <label>Costo (USD)</label>
                <input type="number" wire:model="cost_usd" step="0.01" class="form-control">
            </div>

            <div class="form-group col-md-12">
                <label>Composición</label>
                <textarea wire:model="composition" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-success float-right">{{ $Id==0 ? "Guardar" : "Editar" }}</button>
    </form>
</x-modal>
