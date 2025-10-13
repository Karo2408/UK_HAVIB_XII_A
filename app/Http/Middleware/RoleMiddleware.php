<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (in_array($user->Role, $roles)) {
            return $next($request);
        }

        // Kalau bukan, redirect ke dashboard
        return redirect()->route('dashboard.index')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
    