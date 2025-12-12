<?php

// app/Policies/FeedingEventPolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\feeding_events as FeedingEvent;

class FeedingEventPolicy {
    public function create(User $user) { return $user->hasRole(['Admin','Operator']); }
    public function view(User $user, FeedingEvent $event) { return $user->hasRole(['Admin','Operator','Veterinarian','Auditor']); }
    public function update(User $user, FeedingEvent $event) { return $user->hasRole(['Admin']); }
    public function delete(User $user, FeedingEvent $event) { return $user->hasRole(['Admin']); }
}


