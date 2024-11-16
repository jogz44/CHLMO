<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class JetstreamGuardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('auth.guard.jetstream', function ($app) {
            return new JetstreamGuard(
                $app['auth']->createUserProvider(config('auth.providers.users.driver')),
                $app['request']
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
