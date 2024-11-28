<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Shelter\ShelterIndexController;
use App\Http\Controllers\Housing\HousingStaffIndexController;
use App\Http\Controllers\Admin\PermissionCOntroller;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicantsController;
use App\Http\Controllers\PurokController;
use App\Exports\GranteesDataExport;

use App\Livewire\ApplicantDetails;
use App\Livewire\AwardeeDetails;
use App\Livewire\GranteeDetails;
use App\Livewire\PermissionsManager;
use App\Livewire\ShelterApplicantDetails;
use App\Livewire\ShelterReportAvailabilityMaterials;
use App\Livewire\ProfiledTaggedApplicantDetails;
use App\Livewire\TaggedAndValidatedApplicantDetails;
use App\Livewire\TransactionWalkin;
use App\Livewire\TransferHistories;
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

    Route::get('/activity-logs', function () {
        return view('activity-logs');
    })->name('activity-logs');

    Route::get('/user-role-management', function () {
        return view('user-role-management');
    })->name('user-role-management');

    Route::get('/applicant-details/{applicantId}', ApplicantDetails::class)->name('applicant-details');

    // Tagged and Validated Applicant Details
    Route::get('/tagged-and-validated-applicant-details/{applicantId}', TaggedAndValidatedApplicantDetails::class)
        ->name('tagged-and-validated-applicant-details');

    Route::get('/awardee-details/{applicantId}', AwardeeDetails::class)
        ->name('awardee-details');

    Route::get('/awardee-list', function () {
        return view('awardee-list');
    })->name('awardee-list');

    Route::get('/transfer-histories', TransferHistories::class)->name('transfer-histories');

    Route::get('/blacklist', function () {
        return view('blacklist');
    })->name('blacklist');

    Route::get('/relocation-sites', function () {
        return view('relocation-sites');
    })->name('relocation-sites');

    Route::get('/lot-list-details', function () {
        return view('lot-list-details');
    })->name('lot-list-details');

    Route::get('/masterlist-applicant-details/{applicantId}', App\Livewire\MasterlistApplicantDetails::class)
        ->name('masterlist-applicant-details');

    Route::get('/masterlist-applicants', function () {
        return view('masterlist-applicants');
    })->name('masterlist-applicants');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::get('/summary-of-identified-informal-settlers', function () {
        return view('summary-of-identified-informal-settlers');
    })->name('summary-of-identified-informal-settlers');

    Route::get('/summary-of-relocation-lot-applicants', function () {
        return view('summary-of-relocation-lot-applicants');
    })->name('summary-of-relocation-lot-applicants');

    Route::get('/masterlist-of-actual-occupants', function () {
        return view('masterlist-of-actual-occupants');
    })->name('masterlist-of-actual-occupants');

    Route::get('/request-applicant-details', function () {
        return view('request-applicant-details');
    })->name('request-applicant-details');

    Route::get('/shelter-assistance-applicant-details', function () {
        return view('shelter-assistance-applicant-details');
    })->name('shelter-assistance-applicant-details');

    Route::get('/shelter-applicants-masterlist', function () {
        return view('shelter-applicants-masterlist');
    })->name('shelter-applicants-masterlist');

    Route::get('/shelter-assistance-grantees', function () {
        return view('shelter-assistance-grantees');
    })->name('shelter-assistance-grantees');

    Route::get('/transaction-request', function () {
        return view('transaction-request');
    })->name('transaction-request');

    Route::get('/transaction-shelter-assistance', function () {
        return view('transaction-shelter-assistance');
    })->name('transaction-shelter-assistance');

    Route::get('/applicants', function () {
        return view('applicants');
    })->name('applicants');
    //    Route::get('/transaction-walkin', TransactionWalkin::class)->name('transaction-walkin');

    Route::get('/system-configuration', function () {
        return view('system-configuration');
    })->name('system-configuration');

    //    shelter assistance program
    Route::get('/shelter-dashboard', function () {
        return view('shelter-dashboard');
    })->name('shelter-dashboard');
    //    Route::middleware(['role.shelterAdmin'])->get('/shelter-dashboard', function () {
    //        return view('shelter-dashboard');
    //    })->name('shelter-dashboard');

    Route::get('/shelter-transaction-applicants', function () {
        return view('shelter-transaction-applicants');
    })->name('shelter-transaction-applicants');

    //Route::get('/shelter-tag-applicant', function () {
    //    return view('shelter-tag-applicant');
    //})->name('shelter-tag-applicant');

    Route::get('/shelter-applicant-details/{profileNo}', ShelterApplicantDetails::class)
        ->name('shelter-applicant-details');

    Route::get('/shelter-profiled-tagged-applicants', function () {
        return view('shelter-profiled-tagged-applicants');
    })->name('shelter-profiled-tagged-applicants');

    // Route::get('/shelter-applicant-details', function () {
    //     return view('shelter-applicant-details');
    // })->name('shelter-applicant-details');

    Route::get('/shelter-material-inventory', function () {
        return view('shelter-material-inventory');
    })->name('shelter-material-inventory');

    Route::get('/shelter-materials-list', function () {
        return view('shelter-materials-list');
    })->name('shelter-materials-list');

    // Route::get('/shelter-grantees-details', function () {
    //     return view('shelter-grantees-details');
    // })->name('shelter-grantees-details');

    Route::get('/grantee-details/{profileNo}', GranteeDetails::class)->name('grantee-details');
    Route::get('/profiled-tagged-applicant-details/{profileNo}', ProfiledTaggedApplicantDetails::class)->name('profiled-tagged-applicant-details');

    Route::get('/shelter-grantees', function () {
        return view('shelter-grantees');
    })->name('shelter-grantees');

    Route::get('/export-pdf', [GranteesDataExport::class, 'exportGranteesPdf'])->name('export.pdf');

    Route::get('/shelter-reports-status-applicants', function () {
        return view('shelter-reports-status-applicants');
    })->name('shelter-reports-status-applicants');

    Route::get('/shelter-reports-request-delivered-materials', function () {
        return view('shelter-reports-request-delivered-materials');
    })->name('shelter-reports-request-delivered-materials');

    Route::get('/shelter-reports-availability-materials', function () {
        return view('shelter-reports-availability-materials');
    })->name('shelter-reports-availability-materials');



    // Route::get('/shelter-report-availability-materials', ShelterReportAvailabilityMaterials::class)
    //     ->name('shelter-report-availability-materials');


    Route::get('/shelter-reports-distribution-list', function () {
        return view('shelter-reports-distribution-list');
    })->name('shelter-reports-distribution-list');

    Route::get('/transfer-awardee', function () {
        return view('transfer-awardee');
    })->name('transfer-awardee');

    Route::get('/shelter-system-configuration', function () {
        return view('shelter-system-configuration');
    })->name('shelter-system-configuration');

    Route::get('/developers', function () {
        return view('developers');
    })->name('developers');
    
});


// Housing Admin routes
Route::middleware([
    'auth:web', // Session-based authentication via web guard
    'role:Housing System Admin', // Spatie permission middleware to check if the user has the 'Housing System' role
    'verified', // Ensures the user has verified their email
])->name('admin.')->prefix('admin')->group(function () {

});

// Shelter Admin routes
Route::middleware([
    'auth:web', // Session-based authentication via web guard
    'role:ShelterAdmin', // Spatie permission middleware to check if the user has the 'ShelterAdmin' role
    'verified', // Ensures the user has verified their email
])->name('shelter-admin.')->prefix('shelter-admin')->group(function () {
    Route::get('/', [ShelterIndexController::class, 'index'])->name('index');
});

// Shelter Admin routes
Route::middleware([
    'auth:web', 
    'role:HousingStaff', // Correct Spatie role middleware syntax
    'verified'
])->name('housing-staff.')->prefix('housing-staff')->group(function () {
    Route::get('/', [HousingStaffIndexController::class, 'index'])->name('index');
});
