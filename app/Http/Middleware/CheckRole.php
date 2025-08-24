<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Các role được phép truy cập
        $allowedRoles = ['admin', 'manage'];

        if (!in_array($request->user()->role, $allowedRoles)) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}
