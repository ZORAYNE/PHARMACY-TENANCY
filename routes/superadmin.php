<?php

use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SuperAdminProfileController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\Tenant\DashboardController;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('login', [SuperAdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [SuperAdminAuthController::class, 'login'])->name('login.submit');

    Route::middleware('auth:superadmin')->group(function () {
        Route::get('dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [SuperAdminAuthController::class, 'logout'])->name('logout');

        Route::get('profile/edit', [SuperAdminProfileController::class, 'edit'])->name('profile.edit');
        Route::post('profile/update', [SuperAdminProfileController::class, 'update'])->name('profile.update');
        Route::post('profile/password', [SuperAdminProfileController::class, 'updatePassword'])->name('password.update');

        Route::post('/tenants/{tenant}/approve', [TenantController::class, 'approve'])->name('tenants.approve');
        Route::get('/accept-tenant/{tenant_id}', [TenantController::class, 'acceptTenant'])->name('acceptTenant');
    });
});

