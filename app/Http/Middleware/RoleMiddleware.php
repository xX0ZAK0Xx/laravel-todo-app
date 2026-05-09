<?php

namespace App\Http\Middleware;

use App\Exceptions\BusinessException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();
        if (!$user) {
            throw new BusinessException('Unauthorized', 401);
        }

        if($role === 'admin' && !$user->is_admin) {
            throw new BusinessException('Forbidden', 403);
        }

        return $next($request);
    }
}
