<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $storage = Storage::disk('livewire-tmp');
    foreach ($storage->allFiles() as $filePathname) {
        if ($storage->lastModified($filePathname) < now()->subHours(24)->getTimestamp()) {
            $storage->delete($filePathname);
        }
    }
})->daily();
