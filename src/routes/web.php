<?php

use Illuminate\Support\Facades\Route;
use Dev3bdulrahman\LicenseManager\Http\Controllers\DashboardController;
use Dev3bdulrahman\LicenseManager\Http\Controllers\CustomerController;
use Dev3bdulrahman\LicenseManager\Http\Controllers\LicenseController;

Route::group([
    'prefix' => 'license-manager',
    'as' => 'license-manager.',
    'middleware' => ['web', 'auth']
], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('customers', CustomerController::class);
    Route::resource('licenses', LicenseController::class);
    Route::put('licenses/{license}/suspend', [LicenseController::class, 'suspend'])->name('licenses.suspend');
});