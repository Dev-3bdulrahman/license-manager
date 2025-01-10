<?php

use Dev3bdulrahman\LicenseManager\Http\Controllers\CustomerController;
use Dev3bdulrahman\LicenseManager\Http\Controllers\DashboardController;
use Dev3bdulrahman\LicenseManager\Http\Controllers\LicenseController;
use Dev3bdulrahman\LicenseManager\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'license-manager',
    'as' => 'license-manager.',
    'middleware' => ['web', 'auth'],
], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);
    Route::resource('licenses', LicenseController::class);
    Route::post('licenses/{license}/suspend', [LicenseController::class, 'suspend'])->name('licenses.suspend');
    Route::post('licenses/{license}/reactivate', [LicenseController::class, 'reactivate'])->name('licenses.reactivate');
});
