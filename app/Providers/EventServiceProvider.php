<?php

namespace App\Providers;

use App\Events\TodoCompleted;
use App\Listeners\SendCompletionEmail;
use App\Listeners\UpdateUserStreak;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public $listen = [
        TodoCompleted::class => [
            UpdateUserStreak::class,
            SendCompletionEmail::class,
        ]
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
