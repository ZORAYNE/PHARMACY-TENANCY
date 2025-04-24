<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use App\Mail\TenantApprovedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use App\Providers\TenantDatabaseConnection;
 

class TenantController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:tenants,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $tenant = Tenant::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => 'pending',
        ]);

        Auth::login($tenant);

        return redirect()->route('tenant.dashboard');
    }

    public function acceptTenant($tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);

        $tenant->status = 'accepted';
        $tenant->save();

        $dbName = strtolower(str_replace(' ', '_', $tenant->name));
        DB::statement("CREATE DATABASE `$dbName`");

        config(['database.connections.tenant.database' => $dbName]);

        // Create the tenant's database
        DB::statement("CREATE DATABASE `$dbName`");

        // Dynamically set the tenant connection config
        Config::set('database.connections.tenant', [
            'driver' => 'mysql',
            'host' => env('TENANT_DB_HOST'),
            'database' => $dbName,  // dynamic tenant database name
            'username' => env('TENANT_DB_USERNAME'),
            'password' => env('TENANT_DB_PASSWORD'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]);
        
        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => '/database/migrations/tenant',
            '--force' => true,
        ]);
        
        Artisan::call('db:seed', [
            '--database' => 'tenant',
            '--class' => 'Database\\Seeders\\TenantDatabaseSeeder',
            '--force' => true,
        ]);
        
        $admin = $tenant->admins()->first();

        if ($admin) {
            Mail::to($admin->email)->send(new TenantApprovedMail($tenant));
        }

        return redirect()->back()->with('success', 'Tenant accepted, database created, and admin notified successfully.');
    }

    public function showRegistrationForm()
{
    $tenants = Tenant::all(); // Get all tenants
    return view('auth.register', compact('tenants')); // Pass tenants to view
}

}
