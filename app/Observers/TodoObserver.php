<?php

namespace App\Observers;

use App\Models\Todo;
use Illuminate\Support\Facades\Log;

class TodoObserver
{
    // Fire before creating a new Todo
    public function creating(Todo $todo): void
    {
        // Set default values for new todos
        if (!isset($todo->is_done)) {
            $todo->is_done = false;
        }

        // Log the creation process
        Log::info("Creating Todo", [
            'title' => $todo->title,
            'user_id' => $todo->user_id ?? 'N/A',
        ]);
    }

    /**
     * Handle the Todo "created" event.
     */
    public function created(Todo $todo): void
    {
        // Log todo
        Log::info("Todo Created", [
            'id' => $todo->id,
            'title' => $todo->title,
            'user_id' => $todo->user_id,
        ]);
    }

    // Fire before updating an existing Todo
    public function updating(Todo $todo): void
    {
        if ($todo->isDirty('is_done') && $todo->is_done === true) {
            Log::info("Todo Completed", [
                'id' => $todo->id,
                'title' => $todo->title,
                'user_id' => $todo->user_id,
            ]);
        }

        // Log the updating process
        Log::info("Updating Todo", [
            'id' => $todo->id,
            'title' => $todo->title,
            'changes' => $todo->getChanges(),
        ]);
    }

    /**
     * Handle the Todo "updated" event.
     */
    public function updated(Todo $todo): void
    {
        // log what was updated
        Log::info("Todo Updated", [
            'id' => $todo->id,
            'title' => $todo->title,
            'is_done' => $todo->is_done,
            'user_id' => $todo->user_id,
        ]);
    }

    public function deleting(Todo $todo): void
    {
        Log::info("Todo $todo->id is being deleted", [
            'title' => $todo->title,
        ]);
    }

    /**
     * Handle the Todo "deleted" event.
     */
    public function deleted(Todo $todo): void
    {
        Log::info("Todo $todo->id deleted", [
            'title' => $todo->title,
        ]);
    }

    /**
     * Handle the Todo "restored" event.
     */
    public function restored(Todo $todo): void
    {
        //
    }

    /**
     * Handle the Todo "force deleted" event.
     */
    public function forceDeleted(Todo $todo): void
    {
        //
    }
}
