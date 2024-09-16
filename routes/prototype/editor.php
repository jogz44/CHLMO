<?php

use Illuminate\Support\Facades\Route;

Route::get('/prototype-codes/editor/dashboard', function () {
    return view('prototype-codes.editor.dashboard');
})->name('editor-dashboard');

Route::get('/prototype-codes/editor/transaction-request', function () {
    return view('prototype-codes.editor.transaction-request');
})->name('editor-transaction-request');

Route::get('/prototype-codes/editor/transaction-walkin', function () {
    return view('prototype-codes.editor.transaction-walkin');
})->name('editor-transaction-walkin');

Route::get('/prototype-codes/editor/applicant-details', function () {
    return view('prototype-codes.editor.applicant-details');
})->name('editor-applicant-details');

Route::get('/prototype-codes/editor/request-applicant-details', function () {
    return view('prototype-codes.editor.request-applicant-details');
})->name('editor-request-applicant-details');

Route::get('/prototype-codes/editor/add-new-request', function () {
    return view('prototype-codes.editor.add-new-request');
})->name('editor-add-new-request');

Route::get('/prototype-codes/editor/transaction-shelter-assistance', function () {
    return view('prototype-codes.editor.transaction-shelter-assistance');
})->name('editor-transaction-shelter-assistance');

Route::get('/prototype-codes/editor/shelterAsst-applicant-details', function () {
    return view('prototype-codes.editor.shelterAsst-applicant-details');
})->name('editor-shelterAsst-details');

Route::get('/prototype-codes/editor/masterlist-applicants', function () {
    return view('prototype-codes.editor.masterlist-applicants');
})->name('editor-masterlist-applicants');

Route::get('/prototype-codes/editor/masterlist-applicant-details', function () {
    return view('prototype-codes.editor.masterlist-applicant-details');
})->name('editor-masterlist-applicant-details');

Route::get('/prototype-codes/editor/shelter-assistance-grantees', function () {
    return view('prototype-codes.editor.shelter-assistance-grantees');
})->name('editor-shelter-assistance-grantees');

Route::get('/prototype-codes/editor/awardee-list', function () {
    return view('prototype-codes.editor.awardee-list');
})->name('editor-awardee-list');

Route::get('/prototype-codes/editor/awardee-details', function () {
    return view('prototype-codes.editor.awardee-details');
})->name('editor-awardee-details');

Route::get('/prototype-codes/editor/lot-list', function () {
    return view('prototype-codes.editor.lot-list');
})->name('editor-lot-list');

Route::get('/prototype-codes/editor/blacklist', function () {
    return view('prototype-codes.editor.blacklist');
})->name('editor-blacklist');

Route::get('/prototype-codes/editor/activity-logs', function () {
    return view('prototype-codes.editor.activity-logs');
})->name('editor-activity-logs');

Route::get('/prototype-codes/editor/reports-summary-informal-settlers', function () {
    return view('prototype-codes.editor.reports-summary-informal-settlers');
})->name('editor-reports-summary-informal-settlers');

Route::get('/prototype-codes/editor/reports-summary-relocation-applicants', function () {
    return view('prototype-codes.editor.reports-summary-relocation-applicants');
})->name('editor-reports-summary-relocation-applicants');

Route::get('/prototype-codes/editor/profile', function () {
    return view('prototype-codes.editor.profile');
})->name('editor-profile');