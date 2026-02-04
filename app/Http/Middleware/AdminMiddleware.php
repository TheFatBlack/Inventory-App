<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || strtolower((string) $user->role) !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini. Hanya Admin yang dapat mengakses.');
        }

        return $next($request);
    }
}
