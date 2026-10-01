<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoReadOnlyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Admin tetap mempunyai akses penuh.
        if ($request->user()?->role !== 'demo') {
            return $next($request);
        }

        /*
         * DEMO HANYA BOLEH MEMBACA DATA.
         *
         * Semua request yang berpotensi mengubah database
         * langsung ditolak.
         */
        if ($request->isMethod('POST') ||
            $request->isMethod('PUT') ||
            $request->isMethod('PATCH') ||
            $request->isMethod('DELETE')) {

            abort(403, 'Akun Demo hanya memiliki akses Read Only.');
        }

        /*
         * Blokir halaman:
         * /create
         * /edit
         *
         * Walaupun keduanya menggunakan GET, halaman tersebut
         * merupakan bagian dari proses perubahan data.
         */
        $routeName = $request->route()?->getName();

        if ($routeName) {
            $blockedRoutePatterns = [
                '*.create',
                '*.edit',
                '*.store',
                '*.update',
                '*.destroy',
            ];

            foreach ($blockedRoutePatterns as $pattern) {
                if (\Illuminate\Support\Str::is($pattern, $routeName)) {
                    abort(403, 'Akun Demo hanya memiliki akses Read Only.');
                }
            }
        }

        return $next($request);
    }
}