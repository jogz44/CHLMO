<?php

namespace App\Providers;

use App\Actions\CustomLoginResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Added for redirection (coming from the CustomLoginResponse)
        $this->app->singleton(LoginResponseContract::class, CustomLoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function ($request) {
            $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            \Log::info('Login attempt', [
                'field_type' => $fieldType,
                'value' => $request->username
            ]);

            $user = User::where($fieldType, $request->username)->first();

            \Log::info('User found', [
                'found' => (bool)$user,
                'role_id' => $user?->role_id,
                'is_disabled' => $user?->is_disabled ?? 'not set',
            ]);

            if (!$user) {
                return null;
            }

            $passwordCorrect = Hash::check($request->password, $user->password);
            \Log::info('Password check', ['correct' => $passwordCorrect]);

            if (!$passwordCorrect) {
                return null;
            }

            if ($user->is_disabled && $user->role_id !== 1) {
                throw ValidationException::withMessages([
                    'username' => ['This account has been disabled.'],
                ]);
            }

            return $user;
        });
    }
}
