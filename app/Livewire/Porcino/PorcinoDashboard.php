<?php

namespace App\Livewire\Porcino;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\lots as Lot;
use App\Models\feed_items as FeedItem;
use App\Models\feeding_events as FeedingEvent;
use App\Models\weight_records as WeightRecord;
use App\Models\welfare_checks as WelfareCheck;
use App\Models\Alert;
use App\Models\AuditLog;
use App\Services\GrowthMetrics;

#[Title('Gestion Porcina')]
class PorcinoDashboard extends Component
{
    public $lotsActivos = 0;
    public $stockTotal = 0;
    public $adgPromedio = 0;
    public $alertasCriticas = 0;
    public $alertasPendientes = [];

    public function mount()
    {
        $this->cargarMétricas();
    }

    public function cargarMétricas()
    {
        // Lotes activos
        $this->lotsActivos = Lot::active()->count();

        // Stock total de alimentos
        $this->stockTotal = FeedItem::sum('stock');

        // ADG promedio de todos los lotes activos
        $adgs = [];
        foreach (Lot::active()->get() as $lot) {
            $adgs[] = GrowthMetrics::adgForLot($lot->id);
        }
        $this->adgPromedio = count($adgs) ? round(array_sum($adgs) / count($adgs), 3) : 0;

        // Alertas críticas
        $this->alertasCriticas = Alert::where('level','critical')->where('resolved',false)->count();

        // Últimas alertas pendientes
        $this->alertasPendientes = Alert::where('resolved',false)->latest()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.porcino.porcino-dashboard');
    }
}

