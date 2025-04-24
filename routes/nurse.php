<?php

use App\Http\Controllers\PatientProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('nurse')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.index');
    });

    Route::resource('patients', PatientProfileController::class);
});