<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        // Memastikan hanya mencatat kunjungan untuk halaman yang diinginkan (misalnya, halaman utama)
        if ($request->is('/')) {
            // Rate limiting: maksimum 1 kunjungan per menit per IP
            $ipAddress = $request->ip();
            $cacheKey = 'visitor:' . $ipAddress;

            if (!Cache::has($cacheKey)) {
                $this->trackVisitor($ipAddress);
                Cache::put($cacheKey, true, now()->addMinute());
            }
        }

        return $next($request);
    }

    protected function trackVisitor($ipAddress)
    {
        DB::table('visitors')->insert([
            'ip_address' => $ipAddress,
            'visited_at' => now(),
        ]);
    }
}