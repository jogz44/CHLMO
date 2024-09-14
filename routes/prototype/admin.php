<?php

use Illuminate\Support\Facades\Route;

Route::get('/prototype-codes/admin/dashboard', function () {
    return view('prototype-codes.admin.dashboard');
})->name('dashboard');

Route::get('/prototype-codes/admin/transaction-request', function () {
    return view('prototype-codes.admin.transaction-request');
})->name('transaction-request');

Route::get('/prototype-codes/admin/transaction-walkin', function () {
    return view('prototype-codes.admin.transaction-walkin');
})->name('transaction-walkin');

Route::get('/prototype-codes/admin/applicant-details', function () {
    return view('prototype-codes.admin.applicant-details');
})->name('applicant-details');

Route::get('/prototype-codes/admin/request-applicant-details', function () {
    return view('prototype-codes.admin.request-applicant-details');
})->name('request-applicant-details');

Route::get('/prototype-codes/admin/add-new-request', function () {
    return view('prototype-codes.admin.add-new-request');
})->name('add-new-request');

Route::get('/prototype-codes/admin/transaction-shelter-assistance', function () {
    return view('prototype-codes.admin.transaction-shelter-assistance');
})->name('transaction-shelter-assistance');

Route::get('/prototype-codes/admin/shelterAsst-applicant-details', function () {
    return view('prototype-codes.admin.shelterAsst-applicant-details');
})->name('shelterAsst-details');

Route::get('/prototype-codes/admin/masterlist-applicants', function () {
    return view('prototype-codes.admin.masterlist-applicants');
})->name('masterlist-applicants');

Route::get('/prototype-codes/admin/masterlist-applicant-details', function () {
    return view('prototype-codes.admin.masterlist-applicant-details');
})->name('masterlist-applicant-details');

Route::get('/prototype-codes/admin/shelter-assistance-grantees', function () {
    return view('prototype-codes.admin.shelter-assistance-grantees');
})->name('shelter-assistance-grantees');

Route::get('/prototype-codes/admin/awardee-list', function () {
    return view('prototype-codes.admin.awardee-list');
})->name('awardee-list');

Route::get('/prototype-codes/admin/awardee-details', function () {
    return view('prototype-codes.admin.awardee-details');
})->name('awardee-details');

Route::get('/prototype-codes/admin/lot-list', function () {
    return view('prototype-codes.admin.lot-list');
})->name('lot-list');

Route::get('/prototype-codes/admin/blacklist', function () {
    return view('prototype-codes.admin.blacklist');
})->name('blacklist');