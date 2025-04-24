<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // group in admin contorller
    // Route::resource()

});