<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login DAN memiliki role seller
        // Fungsi isSeller() sudah ada di model User.php Anda
        if ($request->user() && $request->user()->isSeller()) {
            return $next($request);
        }

        // Jika bukan seller, lempar ke halaman utama
        abort(403, 'Akses Ditolak. Halaman ini khusus Penjual.');
    }
}