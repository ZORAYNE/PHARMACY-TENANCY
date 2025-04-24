<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantDatabaseConnection extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // This will ensure that the tenant database connection is set dynamically
        $this->app->singleton('tenant.database', function () {
            // Assuming you have set up the database connection dynamically somewhere else (like in TenantController)
            $tenantDbName = config('database.connections.tenant.database');
            return DB::connection('tenant')->setDatabaseName($tenantDbName);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // You can set up other bootstrapping logic here if needed
    }
}
