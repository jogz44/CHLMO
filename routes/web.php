<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum', // Ensures the user is authenticated using Sanctum
    'role:admin', // Spatie permission middleware to check if the user has the 'admin' role
    config('jetstream.auth_session'), // Jetstream session authentication middleware
    'verified', // Ensures the user has verified their email
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/admin', function () {
        return view('admin.index');
    })->name('admin.index');
});


require __DIR__ . '/prototype/admin.php';
require __DIR__ . '/prototype/editor.php';
