<?php

namespace App\Providers;

use App\Models\Awardee;
use App\Observers\AwardeeObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
        Awardee::observe(AwardeeObserver::class);

        if (!file_exists(public_path('tagging-house-structure-images'))) {
            symlink(
                storage_path('app/tagging-house-structure-images'),
                public_path('tagging-house-structure-images')
            );
        }
    }
}
