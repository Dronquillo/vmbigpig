<!-- resources/views/livewire/growth/lot-weights-panel.blade.php -->
<div class="space-y-6">
  <div class="bg-white p-4 rounded shadow">
    <h3 class="text-sm font-semibold">Registrar pesaje</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
      <input type="date" wire:model.defer="date" class="rounded border-gray-300">
      <input type="number" step="0.001" wire:model.defer="weight_kg" placeholder="Peso kg" class="rounded border-gray-300">
      <button wire:click="save" class="bg-blue-600 text-white rounded px-3">Guardar</button>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm font-semibold">ADG</div>
      <div class="text-2xl">{{ number_format($adg,3) }} kg/día</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm font-semibold">FCR</div>
      <div class="text-2xl">{{ number_format($fcr,3) }}</div>
    </div>
  </div>

  <div class="bg-white p-4 rounded shadow">
    <h3 class="text-sm font-semibold">Historial</h3>
    <div class="mt-2">
      @forelse($entries as $e)
        <div class="text-sm flex justify-between border-b py-1">
          <span>{{ \Illuminate\Support\Carbon::parse($e['date'])->toDateString() }}</span>
          <span>{{ number_format($e['weight_kg'],3) }} kg</span>
        </div>
      @empty
        <div class="text-sm text-gray-500">Sin registros todavía.</div>
      @endforelse
    </div>
  </div>
</div>

