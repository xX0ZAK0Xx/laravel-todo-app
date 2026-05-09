<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //! TodoRepository
        $this->app->bind(
            \App\Repositories\Interfaces\TodoRepositoryInterface::class,
            \App\Repositories\TodoRepository::class
        );

        //! AuthRepository
        $this->app->bind(
            \App\Repositories\Interfaces\AuthRepositoryInterface::class,
            \App\Repositories\AuthRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
