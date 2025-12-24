<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil API Key rahasia dari file konfigurasi .env
        // Jika tidak ada, gunakan nilai default (sebaiknya diisi di .env)
        $apiKey = env('API_SECRET_KEY');

        // Ambil API Key yang dikirim oleh klien dari header permintaan
        $clientApiKey = $request->header('X-API-KEY');

        // Periksa apakah API Key yang dikirim klien valid
        if (!$apiKey || $clientApiKey !== $apiKey) {
            // Jika tidak valid, kirim respons error "Unauthorized"
            return response()->json(['message' => 'Akses Ditolak. API Key tidak valid.'], 401);
        }

        // Jika valid, lanjutkan permintaan ke Controller
        return $next($request);
    }
}