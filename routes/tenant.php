<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TenantAuthController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');
});

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
});


// Tenant routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');
});


Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // Authentication
    Route::prefix('tenant')->group(function () {
        Route::get('register', [TenantController::class, 'registerView'])->name('tenant.register.view');
        Route::post('register', [TenantController::class, 'register'])->name('tenant.register');

        Route::get('{tenant_id}/login', [TenantAuthController::class, 'login'])->name('tenant.login');
        Route::post('{tenant_id}/login', [TenantAuthController::class, 'postLogin'])->name('tenant.login.submit');
        Route::post('logout', [TenantAuthController::class, 'logout'])->name('tenant.logout');
    });

    Route::middleware(['tenant.auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');

        // Role-based resources
        Route::middleware(['role:admin'])->group(function () {
            Route::resource('suppliers', SupplierController::class);
            Route::resource('products', ProductController::class);
            Route::resource('customers', CustomerController::class);
        });

        Route::middleware(['role:admin,pharmacist'])->group(function () {
            Route::resource('sales', SalesController::class);
            Route::get('inventory', [ProductController::class, 'index']);
        });

        // Reports
        Route::get('/reports/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
        Route::get('/reports/customers', [ReportController::class, 'customerTrendReport'])->name('reports.customers');
        Route::get('/reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
    });
});
