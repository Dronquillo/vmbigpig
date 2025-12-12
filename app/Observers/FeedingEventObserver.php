<?php

// app/Observers/FeedingEventObserver.php
namespace App\Observers;

use Livewire\Attributes\Title;
use App\Models\feeding_events as FeedingEvent;
use App\Models\alerts_and_audit_logs as AuditLog;

#[Title('Observador de Eventos de Alimentación')]
class FeedingEventObserver {
    public function created(FeedingEvent $event){
        AuditLog::create([
            'model' => FeedingEvent::class,
            'model_id' => $event->id,
            'user_id' => auth()->id(),
            'action' => 'created',
            'payload' => $event->toArray(),
        ]);
    }
}


