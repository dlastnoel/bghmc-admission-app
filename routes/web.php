<?php

use App\Http\Controllers\Web\AdmissionController;
use App\Http\Controllers\Web\AuthenticationController;
use App\Http\Controllers\Web\PatientController;
use Illuminate\Support\Facades\Route;


// auth
Route::controller(AuthenticationController::class)->group(function () {

    Route::get('/login', 'create')
        ->name('auth.login');

    Route::post('/login', 'store')
        ->name('auth.store');

    Route::delete('/logout', 'destroy')
        ->name('auth.destroy');
});


Route::middleware(['auth'])->group(function () {

    // patients
    Route::resource('/patients', PatientController::class);

    Route::controller(AdmissionController::class)->group(function () {

        Route::get('/admissions', 'index')
            ->name('admissions.index');

        Route::get('/admissions/create', 'create')
            ->name('admissions.create');

        Route::post('/admissions', 'store')
            ->name('admissions.store');

        Route::get('/admissions/{admission}', 'show')
            ->name('admissions.show');
    });
});