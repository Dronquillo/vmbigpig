<?php

// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;

class RoleMiddleware {
    public function handle($request, Closure $next, ...$roles){
        if (!auth()->check() || !auth()->user()->hasRole($roles)) {
            abort(403);
        }
        return $next($request);
    }
}
