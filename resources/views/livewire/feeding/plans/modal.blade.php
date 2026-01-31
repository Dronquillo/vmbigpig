<x-modal modalId="modalPlan" modalTitle="Plan de Alimentación" modalSize="modal-lg">

    <form wire:submit={{ $Id==0 ? "store" : "update($Id)" }}>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Lote</label>
                <select wire:model="lot_id" class="form-control">
                    <option value="">-- Seleccione un lote --</option>
                    @foreach($lots as $lot)
                        <option value="{{ $lot->id }}">{{ $lot->code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Fórmula</label>
                <select wire:model="formula_id" class="form-control">
                    <option value="">-- Seleccione una Formula --</option>
                    @foreach($formulas as $formula)
                        <option value="{{ $formula->id }}">{{ $formula->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label>Día Desde</label>
                <input type="number" wire:model="day_from" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Día Hasta</label>
                <input type="number" wire:model="day_to" class="form-control">
            </div>
            <div class="form-group col-md-4">
                <label>Ración por Cerdo (kg)</label>
                <input type="number" step="0.01" wire:model="ration_per_pig_kg" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-success float-right">{{ $Id==0 ? "Guardar" : "Editar" }}</button>

    </form>

</x-modal>
