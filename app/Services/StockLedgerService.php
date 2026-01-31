<?PHP

// app/Services/StockLedgerService.php
namespace App\Services;

use App\Models\Producto;
use App\Models\CompraDetalle;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StockLedgerService
{
    // Entrada por compra
    public function applyPurchase(CompraDetalle $detalle): void
    {
        DB::transaction(function () use ($detalle) {
            $producto = $detalle->producto()->lockForUpdate()->first();
            $producto->stock = round($producto->stock + $detalle->cantidad, 3);
            // Opcional: actualizar precio base (promedio ponderado)
            // $producto->precio = $this->weightedPrice($producto->precio, $producto->stock, $detalle->precio_compra, $detalle->cantidad);
            $producto->save();
        });
    }

    // Salida por evento de alimentación
    public function consume(array $composition): void
    {
        DB::transaction(function () use ($composition) {
            foreach ($composition as $item) {
                $producto = Producto::lockForUpdate()->findOrFail($item['producto_id']);
                $producto->stock = round($producto->stock - $item['kg'], 3);
                if ($producto->stock < 0) { throw new InvalidArgumentException('Stock insuficiente para producto '.$producto->id); }
                $producto->save();
            }
        });
    }

    private function weightedPrice(float $currentPrice, float $currentQty, float $incomingPrice, float $incomingQty): float
    {
        if ($currentQty + $incomingQty <= 0) return $incomingPrice;
        return round((($currentPrice * $currentQty) + ($incomingPrice * $incomingQty)) / ($currentQty + $incomingQty), 4);
    }
}
