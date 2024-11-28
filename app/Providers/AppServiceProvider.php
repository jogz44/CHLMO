<?php

namespace App\Providers;

use App\Models\Awardee;
use App\Observers\AwardeeObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
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

        Storage::disk('tagging-house-structure-images')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
            return URL::to('storage/tagging-house-structure-images/'.$path);
        });
    }
}
