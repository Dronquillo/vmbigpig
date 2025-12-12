<!-- resources/views/livewire/feeding/feed-inventory-manager.blade.php -->
<div class="space-y-6">
  <div class="bg-white p-4 rounded shadow">
    <h3 class="text-sm font-semibold">Nuevo insumo</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
      <input type="text" placeholder="Nombre" wire:model.defer="name" class="rounded border-gray-300">
      <input type="number" step="0.0001" placeholder="Costo por unidad" wire:model.defer="cost_per_unit" class="rounded border-gray-300">
      <div class="flex gap-2">
        <input type="number" step="0.001" placeholder="Stock" wire:model.defer="stock" class="flex-1 rounded border-gray-300">
        <button wire:click="create" class="bg-green-600 text-white rounded px-3">Agregar</button>
      </div>
    </div>
  </div>

  <div class="bg-white p-4 rounded shadow">
    <h3 class="text-sm font-semibold">Inventario</h3>
    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
      @foreach($items as $item)
        <div class="border rounded p-3">
          <div class="flex justify-between items-center">
            <div>
              <div class="text-sm font-medium">{{ $item->name }}</div>
              <div class="text-xs text-gray-500">Costo: ${{ number_format($item->cost_per_unit,4) }}</div>
            </div>
            <div class="text-xs {{ $item->stock < 50 ? 'text-red-600' : 'text-gray-600' }}">
              Stock: {{ number_format($item->stock,3) }} kg
            </div>
          </div>
          <div class="mt-2 flex gap-2">
            <input type="number" step="0.001" class="flex-1 rounded border-gray-300" wire:model.defer="stock">
            <button class="bg-blue-600 text-white rounded px-3" wire:click="updateStock({{ $item->id }}, $wire.stock)">Actualizar</button>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

