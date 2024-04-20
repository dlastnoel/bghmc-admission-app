<?php

use App\Http\Controllers\Web\AdmissionController;
use App\Http\Controllers\Web\AuthenticationController;
use App\Http\Controllers\Web\DischargeAdmissionController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PatientController;
use Illuminate\Support\Facades\Route;

// home
Route::get('/', [HomeController::class, 'index'])
    ->name('home.index');


// auth
Route::controller(AuthenticationController::class)->group(function () {

    Route::get('/login', 'create')
        ->name('auth.create');

    Route::post('/login', 'store')
        ->name('auth.store');

    Route::delete('/logout', 'destroy')
        ->name('auth.destroy')
        ->middleware(['auth']);
});


Route::middleware(['auth'])->group(function () {

    // patients
    Route::controller(PatientController::class)->group(function () {

        Route::get('/patients', 'index')
            ->name('patients.index');

        Route::get('/patients/create', 'create')
            ->name('patients.create');

        Route::post('/patients', 'store')
            ->name('patients.store');

        Route::get('/patients/{patient}/edit', 'edit')
            ->name('patients.edit');

        Route::put('/patients/{patient}', 'update')
            ->name('patients.update');

        Route::delete('/patients/{patient}', 'destroy')
            ->name('patients.destroy');
    });

    // admissions
    Route::controller(AdmissionController::class)->group(function () {

        Route::get('/admissions', 'index')
            ->name('admissions.index');

        Route::match(['get', 'post'], '/admissions/create', 'create')
            ->name('admissions.create');

        Route::post('/admissions', 'store')
            ->name('admissions.store');
    });

    // discharge admissions
    Route::post('/discharge-admissions', [DischargeAdmissionController::class, 'store'])
        ->name('discharge-admissions.store');
});
