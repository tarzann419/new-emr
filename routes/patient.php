<?php

use App\Http\Controllers\PatientProfileController;
use Illuminate\Support\Facades\Route;


Route::prefix('patient')->middleware(['auth', 'verified', 'role:patient'])->group(function () {
    // group in doctor contorller
    Route::resource('patient', PatientProfileController::class)->except(['create', 'edit']);
});