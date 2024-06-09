<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect('/Dashboard');
            } elseif ($user->role == 'superadmin') {
                return redirect('/superadmin-dashboard');
            }
            // Jika pengguna adalah user biasa, arahkan ke halaman booking
            return redirect('/');
        }

        return $next($request);
    }
}
