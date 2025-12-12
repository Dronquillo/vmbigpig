<!-- resources/views/livewire/welfare/welfare-checks-panel.blade.php -->
<div class="space-y-6">
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div>
      <label class="block text-sm font-medium">Lote</label>
      <select wire:model.live="lotId" class="mt-1 w-full rounded border-gray-300">
        <option value="">Seleccione</option>
        @foreach($lots as $lot)
          <option value="{{ $lot->id }}">{{ $lot->code }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium">Fecha</label>
      <input type="date" wire:model.defer="date" class="mt-1 w-full rounded border-gray-300">
    </div>
    <div>
      <label class="block text-sm font-medium">Condición</label>
      <input type="text" wire:model.defer="condition" class="mt-1 w-full rounded border-gray-300" placeholder="Ventilación, heridas...">
    </div>
    <div>
      <label class="block text-sm font-medium">Severidad</label>
      <select wire:model.defer="severity" class="mt-1 w-full rounded border-gray-300">
        <option value="low">Baja</option>
        <option value="medium">Media</option>
        <option value="high">Alta</option>
      </select>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="md:col-span-2">
      <label class="block text-sm font-medium">Notas</label>
      <textarea wire:model.defer="notes" rows="3" class="mt-1 w-full rounded border-gray-300"></textarea>
    </div>
    <div class="flex items-end">
      <label class="inline-flex items-center">
        <input type="checkbox" wire:model.defer="vet_required" class="rounded border-gray-300">
        <span class="ml-2 text-sm">Requiere veterinario</span>
      </label>
    </div>
  </div>

  <div class="flex justify-end">
    <button wire:click="save" class="bg-blue-600 text-white rounded px-4 py-2">Guardar chequeo</button>
  </div>

  <div class="bg-white p-4 rounded shadow">
    <h3 class="text-sm font-semibold">Últimos chequeos</h3>
    <div class="mt-2 space-y-2">
      @foreach($checks as $c)
        <div class="text-sm flex justify-between border-b py-1">
          <span>{{ $c->date->toDateString() }} — {{ $c->condition }}</span>
          <span class="{{ $c->severity === 'high' ? 'text-red-600' : 'text-gray-600' }}">{{ ucfirst($c->severity) }}</span>
        </div>
      @endforeach
      @if($checks->isEmpty())
        <div class="text-sm text-gray-500">Sin registros.</div>
      @endif
    </div>
  </div>
</div>

