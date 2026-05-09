<?php

namespace App\Jobs;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendTodoCompletedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $retries = 3;
    public int $timeout = 30;
    public int $backoff = 60;
    /**
     * Create a new job instance.
     */
    public function __construct(public readonly Todo $todo, public readonly User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Sending todo completion email', [
            'user_email' => $this->user->email,
            'todo_id'    => $this->todo->id,
            'todo_title' => $this->todo->title,
        ]);

        Log::info('Email sent successfully', ['user_email' => $this->user->email]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Failed to send todo completion email', [
            'user_email' => $this->user->email,
            'todo_id'    => $this->todo->id,
            'todo_title' => $this->todo->title,
            'error'      => $exception->getMessage(),
        ]);
    }
}
