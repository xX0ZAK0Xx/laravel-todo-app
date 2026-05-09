<?php

namespace App\Listeners;

use App\Events\TodoCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserStreak implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TodoCompleted $event): void
    {
        $user = $event->user;
        $user->increment('todos_completed_count');
    }
}
