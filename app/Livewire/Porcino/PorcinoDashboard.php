<?php

namespace App\Livewire\Porcino;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\lots as Lot;
use App\Models\Activovivo;
use App\Models\Producto as FeedItem;
use App\Models\feeding_events as FeedingEvent;
use App\Models\weight_records as WeightRecord;
use App\Models\welfare_checks as WelfareCheck;
use App\Models\Alert;
use App\Services\GrowthMetrics;

#[Title('Gestión Porcina')]
class PorcinoDashboard extends Component
{
    public $lotsActivos = 0;
    public $animalesVivos = 0;
    public $stockTotal = 0;
    public $adgPromedio = 0;
    public $alertasCriticas = 0;

    public $alertasPendientes = [];
    public $ultimoFeedingEvents = [];
    public $ultimoPesajes = [];
    public $ultimoWelfareChecks = [];

    public function mount()
    {
        $this->cargarMétricas();
    }

    public function cargarMétricas()
    {
        // Lotes activos
        $this->lotsActivos = Lot::where('end_date', null)->count();

        // Animales vivos
        $this->animalesVivos = ActivoVivo::where('estado','activo')->count();

        // Stock total de alimentos
        $this->stockTotal = FeedItem::sum('stock');

        // ADG promedio de todos los lotes activos
        $adgs = [];
        foreach (Lot::where('end_date', null)->get() as $lot) {
            $adgs[] = GrowthMetrics::adgForLot($lot->id);
        }
        $this->adgPromedio = count($adgs) ? round(array_sum($adgs) / count($adgs), 3) : 0;

        // Alertas críticas
        $this->alertasCriticas = Alert::where('level','critical')->where('resolved',false)->count();

        // Últimas alertas pendientes
        $this->alertasPendientes = Alert::where('resolved',false)->latest()->take(5)->get();

        // Últimos eventos de alimentación
        $this->ultimoFeedingEvents = FeedingEvent::latest()->take(5)->get();

        // Últimos registros de peso
        $this->ultimoPesajes = WeightRecord::latest()->take(5)->get();

        // Últimos chequeos de bienestar
        $this->ultimoWelfareChecks = WelfareCheck::latest()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.porcino.porcino-dashboard');
    }
}


