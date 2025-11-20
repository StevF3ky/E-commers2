<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
      
        if ($request->user() && $request->user()->isSeller()) {
            return $next($request);
        }

        
        abort(403, 'Akses Ditolak. Halaman ini khusus Penjual.');
    }
}