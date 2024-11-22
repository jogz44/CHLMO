<?php

namespace App\Actions;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Check if user has 'housing' role
        if (Auth::user()->hasRole('Housing System Admin')) {
            return redirect('/dashboard');
        }

        // Check if user has 'shelter' role
        if (Auth::user()->hasRole('Shelter System Admin')) {
            return redirect('/shelter-dashboard');
        }

        // Fallback to a default route if no specific role matches
        return redirect('/');
    }
}
