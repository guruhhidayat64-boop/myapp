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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah pengguna sudah login DAN perannya ada di dalam daftar $roles yang diizinkan
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            // Jika tidak, tendang mereka ke halaman utama
            abort(403, 'AKSES DITOLAK');
        }

        // Jika lolos pengecekan, lanjutkan ke halaman yang dituju
        return $next($request);
    }
}
