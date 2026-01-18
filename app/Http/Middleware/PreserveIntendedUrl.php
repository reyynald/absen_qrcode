<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreserveIntendedUrl
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user belum login dan mencoba akses /absen/{token}
        // Simpan URL tersebut agar bisa di-redirect setelah login
        if (!auth()->check() && $request->is('absen/*')) {
            session(['url.intended' => $request->fullUrl()]);
        }

        return $next($request);
    }
}
