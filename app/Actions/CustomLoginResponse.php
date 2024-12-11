<?php

namespace App\Actions;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // Super Admin
        if (Auth::user()->hasRole('Super Admin')) {
            return redirect('/dashboard');
        }
        // Housing System Admin
        if (Auth::user()->hasRole('Housing System Admin')) {
            return redirect('/dashboard');
        }
        // Housing System Staff
        if (Auth::user()->hasRole('Housing System Staff')) {
            return redirect('/dashboard');
        }
        // Housing System Tagger
        if (Auth::user()->hasRole('Housing System Tagger')) {
            return redirect('/applicants');
        }
        // Housing System Tagger
        if (Auth::user()->hasRole('Housing System Relocation Site Manager')) {
            return redirect('/relocation-sites');
        }

        if (Auth::user()->hasRole('Shelter System Admin')) {
            return redirect('/shelter-dashboard');
        }

        // Fallback to a default route if no specific role matches
        return redirect('/');
    }
}
