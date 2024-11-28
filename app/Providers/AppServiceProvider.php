<?php

namespace App\Providers;

use App\Models\Awardee;
use App\Observers\AwardeeObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

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
    public function boot()
    {
        Paginator::useTailwind();
        Awardee::observe(AwardeeObserver::class);

        if (!file_exists(public_path('tagging-house-structure-images'))) {
            try {
                symlink(
                    storage_path('app/tagging-house-structure-images'),
                    public_path('tagging-house-structure-images')
                );
            } catch (\Exception $e) {
                Log::error('Failed to create symbolic link: ' . $e->getMessage());
            }
        }
    }
}
