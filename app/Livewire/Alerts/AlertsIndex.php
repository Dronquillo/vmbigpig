<?php

namespace App\Livewire\Alerts;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Alert;

#[Title('Alertas')]
class AlertsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $level = '';
    public $resolved = '';
    public $perPage = 10;

    public $selectedAlert = null;
    public $showDetail = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'level' => ['except' => ''],
        'resolved' => ['except' => ''],
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingType()   { $this->resetPage(); }
    public function updatingLevel()  { $this->resetPage(); }
    public function updatingResolved(){ $this->resetPage(); }
    public function updatingPerPage(){ $this->resetPage(); }

    public function render()
    {
        $alerts = Alert::query()
            ->when($this->search, function ($q) {
                $q->where(function ($qq) {
                    $qq->where('type', 'like', "%{$this->search}%")
                       ->orWhere('level', 'like', "%{$this->search}%")
                       ->orWhere('alertable_type', 'like', "%{$this->search}%");
                });
            })
            ->when($this->type, fn($q) => $q->where('type', $this->type))
            ->when($this->level, fn($q) => $q->where('level', $this->level))
            ->when($this->resolved !== '', fn($q) => $q->where('resolved', $this->resolved === '1'))
            ->latest()
            ->paginate($this->perPage);

        $total     = Alert::count();
        $criticas  = Alert::where('level','critical')->where('resolved',false)->count();
        $pendientes= Alert::where('resolved',false)->count();
        $resueltas = Alert::where('resolved',true)->count();

        return view('livewire.alerts.index', compact('alerts','total','criticas','pendientes','resueltas'));
    }

    public function verDetalle($id)
    {
        $this->selectedAlert = Alert::findOrFail($id);
        $this->showDetail = true;
        $this->dispatch('open-modal','modalAlertDetail');
    }

    public function cerrarDetalle()
    {
        $this->showDetail = false;
        $this->selectedAlert = null;
        $this->dispatch('close-modal','modalAlertDetail');
    }

    public function toggleResolved($id)
    {
        $alert = Alert::findOrFail($id);
        $alert->resolved = ! $alert->resolved;
        $alert->save();

        $this->dispatch('toast', type: 'success', message: $alert->resolved ? 'Alerta marcada como resuelta' : 'Alerta marcada como pendiente');
    }

    public function limpiarFiltros()
    {
        $this->reset(['search','type','level','resolved']);
        $this->resetPage();
    }
    
}
