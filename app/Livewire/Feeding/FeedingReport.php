<?php

namespace App\Livewire\Feeding;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\feeding_events as FeedingEvent;
use App\Models\lots as Lot;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FeedingEventsExport;

#[Title('Reporte de Alimentación')]
class FeedingReport extends Component
{
    public $events;
    public $lots;
    public $selectedLot = '';
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->lots = Lot::all();
        $this->loadEvents();
    }

    public function updatedSelectedLot()
    {
        $this->loadEvents();
    }

    public function updatedStartDate()
    {
        $this->loadEvents();
    }

    public function updatedEndDate()
    {
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $query = FeedingEvent::with('lot','pig');

        if ($this->selectedLot) {
            $query->where('lot_id', $this->selectedLot);
        }

        if ($this->startDate) {
            $query->whereDate('date','>=',$this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('date','<=',$this->endDate);
        }

        $this->events = $query->latest()->get();
    }

    public function exportPDF()
    {
        $pdf = Pdf::loadView('exports.feeding-report-pdf', ['events' => $this->events]);
        return response()->streamDownload(fn() => print($pdf->output()), 'feeding_report.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new FeedingEventsExport($this->events), 'feeding_report.xlsx');
    }

    public function exportCSV()
    {
        return Excel::download(new FeedingEventsExport($this->events), 'feeding_report.csv');
    }

    public function render()
    {
        return view('livewire.feeding.feeding-report', [
            'events' => $this->events,
            'lots' => $this->lots
        ]);
    }
}

