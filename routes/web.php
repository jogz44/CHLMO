<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Shelter\ShelterIndexController;
use App\Http\Controllers\Admin\PermissionCOntroller;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicantsController;
use App\Http\Controllers\PurokController;

use App\Livewire\ApplicantDetails;
use App\Livewire\TransactionWalkin;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return view('auth.login');
});

//Route::middleware([
//    'auth:sanctum', // Ensures the user is authenticated using Sanctum
//    config('jetstream.auth_session'), // Jetstream session authentication middleware
//    'verified', // Ensures the user has verified their email
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard');
//    })->name('dashboard');
//});

// Routes for authenticated web users
Route::middleware([
    'auth:web', // Session-based authentication via web guard
    'verified', // Ensures the user has verified their email
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // GET Requests
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/get-puroks/{barangay}', [PurokController::class, 'getPuroks']);

    Route::get('/activity-logs', function () {
        return view('activity-logs');
    })->name('activity-logs');

    Route::get('/add-new-request', function () {
        return view('add-new-request');
    })->name('add-new-request');

//    Route::get('/applicant-details', function () {
//        return view('applicant-details');
//    })->name('applicant-details');
    Route::get('/applicant-details/{applicantId}', ApplicantDetails::class)->name('applicant-details');

    Route::get('/awardee-details', function () {
        return view('awardee-details');
    })->name('awardee-details');

    Route::get('/awardee-list', function () {
        return view('awardee-list');
    })->name('awardee-list');

    Route::get('/blacklist', function () {
        return view('blacklist');
    })->name('blacklist');

    Route::get('/lot-list', function () {
        return view('lot-list');
    })->name('lot-list');

    Route::get('/lot-list-details', function () {
        return view('lot-list-details');
    })->name('lot-list-details');

    Route::get('/masterlist-applicant-details', function () {
        return view('masterlist-applicant-details');
    })->name('masterlist-applicant-details');

    Route::get('/masterlist-applicants', function () {
        return view('masterlist-applicants');
    })->name('masterlist-applicants');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/reports-summary-informal-settlers', function () {
        return view('reports-summary-informal-settlers');
    })->name('reports-summary-informal-settlers');

    Route::get('/reports-summary-relocation-applicants', function () {
        return view('reports-summary-relocation-applicants');
    })->name('reports-summary-relocation-applicants');

    Route::get('/request-applicant-details', function () {
        return view('request-applicant-details');
    })->name('request-applicant-details');

    Route::get('/shelter-assistance-applicant-details', function () {
        return view('shelter-assistance-applicant-details');
    })->name('shelter-assistance-applicant-details');

    Route::get('/shelter-assistance-grantees', function () {
        return view('shelter-assistance-grantees');
    })->name('shelter-assistance-grantees');

    Route::get('/transaction-request', function () {
        return view('transaction-request');
    })->name('transaction-request');

    Route::get('/transaction-shelter-assistance', function () {
        return view('transaction-shelter-assistance');
    })->name('transaction-shelter-assistance');

    Route::get('/transaction-walkin', function () {
        return view('transaction-walkin');
    })->name('transaction-walkin');
//    Route::get('/transaction-walkin', TransactionWalkin::class)->name('transaction-walkin');

    Route::get('/user-settings', function () {
        return view('user-settings');
    })->name('user-settings');

    //shelter assistance program
    Route::get('/shelter-dashboard', function () {
        return view('shelter-dashboard');
    })->name('shelter-dashboard');

    Route::get('/shelter-transaction-applicants', function () {
        return view('shelter-transaction-applicants');
    })->name('shelter-transaction-applicants');

    Route::get('/shelter-tag-applicant', function () {
        return view('shelter-tag-applicant');
    })->name('shelter-tag-applicant');

    Route::get('/shelter-profiled-tagged-applicants', function () {
        return view('shelter-profiled-tagged-applicants');
    })->name('shelter-profiled-tagged-applicants');

    Route::get('/shelter-applicant-details', function () {
        return view('shelter-applicant-details');
    })->name('shelter-applicant-details');

    Route::get('/shelter-material-inventory', function () {
        return view('shelter-material-inventory');
    })->name('shelter-material-inventory');

    Route::get('/shelter-grantees-details', function () {
        return view('shelter-grantees-details');
    })->name('shelter-grantees-details');

    Route::get('/shelter-grantees', function () {
        return view('shelter-grantees');
    })->name('shelter-grantees');

    Route::get('/shelter-reports-status-applicants', function () {
        return view('shelter-reports-status-applicants');
    })->name('shelter-reports-status-applicants');

    Route::get('/shelter-reports-request-delivered-materials', function () {
        return view('shelter-reports-request-delivered-materials');
    })->name('shelter-reports-request-delivered-materials');

    Route::get('/shelter-reports-availability-materials', function () {
        return view('shelter-reports-availability-materials');
    })->name('shelter-reports-availability-materials');

    Route::get('/shelter-reports-distribution-list', function () {
        return view('shelter-reports-distribution-list');
    })->name('shelter-reports-distribution-list');
});


// Admin routes
Route::middleware([
    'auth:web', // Session-based authentication via web guard
    'role:Admin', // Spatie permission middleware to check if the user has the 'admin' role
    'verified', // Ensures the user has verified their email
])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');

    Route::resource('/roles', RoleController::class);
    Route::post('/roles{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/roles{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');

    Route::resource('/permissions', PermissionController::class);
    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/permissions{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');

    Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');
});

// Shelter Admin routes
Route::middleware([
    'auth:web', // Session-based authentication via web guard
    'role:ShelterAdmin', // Spatie permission middleware to check if the user has the 'admin' role
    'verified', // Ensures the user has verified their email
])->name('shelter-admin.')->prefix('shelter-admin')->group(function () {
    Route::get('/', [ShelterIndexController::class, 'index'])->name('index');
});


