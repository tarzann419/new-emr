<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('appointments', AppointmentController::class)
    ->middleware(['auth', 'verified'])
    ->except(['show', 'edit', 'update']);


// Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
//     Route::controller(AdminDashboardController::class)->group(function () {
//         Route::get('/dashboard', 'index')->name('admin.dashboard');
//     });
// });


Route::prefix('fetch')->middleware(['auth', 'verified'])->group(function () {
    Route::get('doctor-schedule/{doctorId}', [AppointmentController::class, 'getDoctorSchedule'])->name('fetch.doctor.schedule');
});

require __DIR__.'/auth.php';


