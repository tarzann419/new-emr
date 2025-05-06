<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\VitalsManagementController;
use Illuminate\Support\Facades\Route;

Route::prefix('nurse')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.index');
    });

    Route::resource('patients', PatientProfileController::class);
    Route::put('/appointments/{id}/reschedule', [AppointmentController::class, 'rescheduleAppointment'])->name('appointments.reschedule');

    Route::get('/vitals/{appointmentId}/{patientId}', [VitalsManagementController::class, 'patientVitals'])->name('vitals.patient');
    Route::post('/vitals', [VitalsManagementController::class, 'store'])->name('store.vitals.patient');
    Route::post('/vitals/{vitalId}', [VitalsManagementController::class, 'update'])->name('update.vitals.patient');
    Route::delete('/vitals/{vitalId}', [VitalsManagementController::class, 'destroy'])->name('destroy.vitals.patient');
});