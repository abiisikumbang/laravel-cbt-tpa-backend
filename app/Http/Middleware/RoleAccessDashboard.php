<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleAccessDashboard
{
    /**
     * Menangani request yang masuk.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // if ($user->roles === 'USER') {
        //     return redirect()->route('login')->withErrors(['error' => 'Akses ditolak']);
        // }

        if ($user->roles === 'ADMIN' || $user->roles === 'STAFF') {
            return $next($request);
        }

        abort(403, 'Akses ditolak');
    }
}

