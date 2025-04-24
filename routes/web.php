<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantRegisterController;
use App\Http\Controllers\TenantController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TenantAuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Models\Tenant;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\SuperAdminProfileController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TenantApprovedMail;
use App\Models\Admin;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// In your routes/web.php
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisteredUserController::class, 'register'])->name('register');


Route::get('/test-mail', function () {
    // Get all admins
    $admins = Admin::all();

    // Send email to each admin
    foreach ($admins as $admin) {
        // Get the tenant associated with the admin
        $tenant = Tenant::find($admin->tenant_id);

        // Send the email with the tenant information
        Mail::to($admin->email)->send(new TenantApprovedMail($tenant));
    }

    return "Test emails sent!";
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('admin.')->group(function () {
    Route::post('/accept/{id}', [SuperAdminController::class, 'accept'])->name('accept');
    Route::delete('/remove/{id}', [SuperAdminController::class, 'remove'])->name('remove');
    Route::patch('/disable/{id}', [SuperAdminController::class, 'disable'])->name('disable');
});


Route::get('/', function () {
    return view('auth/login');
});

// Google Auth Routes
Route::get('auth/google', [TenantAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [TenantAuthController::class, 'handleGoogleCallback']);

Route::middleware(['auth'])->get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');


Route::get('/tenant/{tenantId}/dashboard', [TenantController::class, 'dashboard'])->name('tenant.dashboard');


// Default Auth Routes
require __DIR__.'/auth.php';
