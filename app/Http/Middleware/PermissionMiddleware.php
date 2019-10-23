<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param array $permission
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permission)
    {
        return $next($request);
    }
}
