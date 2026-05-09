<?php

namespace App\Listeners;

use App\Events\TodoCompleted;
use App\Jobs\SendTodoCompletedEmailJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCompletionEmail implements ShouldQueue
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
        SendTodoCompletedEmailJob::dispatch($event->todo, $event->user);
    }
}
