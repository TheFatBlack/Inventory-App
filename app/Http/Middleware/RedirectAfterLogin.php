<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAfterLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($user = $request->user()) {

            return match ($user->role) {
                'admin'    => redirect('/admin/dashboard'),
                'petugas'  => redirect('/petugas/dashboard'),
                'pengguna' => redirect('/pengguna/dashboard'),
                default    => redirect('/login'),
            };
        }
        
        return $next($request);
    }
}