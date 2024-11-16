<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        // If user is logged in but accessing the default dashboard
        if ($request->is('dashboard') || $request->is('/')) {
            if (auth()->user()->hasRole('ShelterAdmin')) {
                return redirect()->route('shelter-dashboard');
            }
        }
        return $next($request);
    }
}
