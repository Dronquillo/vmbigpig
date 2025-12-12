<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FeedingEventsExport implements FromView
{
    protected $events;

    public function __construct($events)
    {
        $this->events = $events;
    }

    public function view(): View
    {
        return view('exports.feeding-report-excel', [
            'events' => $this->events
        ]);
    }
}
