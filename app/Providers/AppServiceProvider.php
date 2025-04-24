<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\TenancyServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register()
{
    //
}
public function map()
{
    $this->mapWebRoutes();
    $this->mapSuperAdminRoutes();
    $this->mapTenantRoutes();
}

protected function mapWebRoutes()
{
    Route::middleware('web')
        ->group(base_path('routes/web.php'));
}

protected function mapSuperAdminRoutes()
{
    Route::middleware('web')
        ->group(base_path('routes/superadmin.php'));
}

protected function mapTenantRoutes()
{
    Route::middleware(['web'])
        ->group(base_path('routes/tenant.php'));
}


}
