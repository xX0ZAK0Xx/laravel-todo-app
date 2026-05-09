<?php

use App\Http\Middleware\RoleMiddleware;
use App\Providers\EventServiceProvider;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        using: function () {
            // public API routes
            Route::middleware(['api'])
                ->prefix('api/v1/public')
                ->name('public.')
                ->group(base_path('routes/api-public-v1.php'));

            // user API routes
            Route::middleware(['api', 'auth:sanctum'])
                ->prefix('api/v1/user')
                ->name('user.')
                ->group(base_path('routes/api-user-v1.php'));

            // admin API routes
            Route::middleware(['api', 'auth:sanctum', 'role:admin'])
                ->prefix('api/v1/admin')
                ->name('admin.')
                ->group(base_path('routes/api-admin-v1.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role'=> RoleMiddleware::class
        ]);
        Authenticate::redirectUsing(fn (Request $request) => null);
    })
    ->withProviders([
        EventServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function(\Throwable $e, Request $request){
            if($request->expectsJson() || $request->is('api/*')){
                // ValidationException 422
                if($e instanceof \Illuminate\Validation\ValidationException) {
                    return response()->json([
                        'message' => 'Validation failed',
                        'errors' => $e->errors(),
                    ], 422);
                }
                // Auth exceptions 401
                if($e instanceof \Illuminate\Auth\AuthenticationException) {
                    return response()->json([
                        'message' => 'Unauthenticated',
                    ], 401);
                }
                // Authorization exceptions 403
                if($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                    return response()->json([
                        'message' => 'Forbidden',
                    ], 403);
                }
                // Route/Model not found 404
                // Note: Laravel's prepareException() converts ModelNotFoundException to
                // NotFoundHttpException before render callbacks run, so we check getPrevious().
                if($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                    $previous = $e->getPrevious();
                    if ($previous instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                        $model = class_basename($previous->getModel());
                        return response()->json([
                            'message' => "$model not found",
                        ], 404);
                    }
                    return response()->json([
                        'message' => 'Route not found',
                    ], 404);
                }
                // Everything else 500
                return response()->json([
                    'message' => app()->isProduction() ? 'Server error' : $e->getMessage(),
                ], 500);
            }
        });
    })->create();
