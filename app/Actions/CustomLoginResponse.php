<?php

namespace App\Actions;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Check what role
        if (Auth::user()->hasRole('Housing System Admin')) {
            return redirect('/dashboard');
        }

        if (Auth::user()->hasRole('Super Admin')) {
            return redirect('/dashboard');
        }

        if (Auth::user()->hasRole('Shelter System Admin')) {
            return redirect('/shelter-dashboard');
        }

        // Fallback to a default route if no specific role matches
        return redirect('/');
    }
}
