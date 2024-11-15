<?php

namespace App\Guards;

use Laravel\Fortify\Guard as FortifyGuard;
use Illuminate\Validation\ValidationException;

class JetstreamGuard extends FortifyGuard
{
    /**
     * Create a new class instance.
     */
//    public function attempt(array $credentials, bool $remember = false)
//    {
//        $user = $this->provider->retrieveByCredentials($credentials);
//
//        if ($user && $user->is_disabled) {
//            throw ValidationException::withMessages([
//                'email' => ['This account has been disabled.'],
//            ]);
//        }
//
//        return parent::attempt($credentials, $remember);
//    }
    public function __construct()
    {
        //
    }
}
