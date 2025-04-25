<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\TenantApprovedMail;

class SuperAdminController extends Controller
{
    public function index()
{
    $tenants = Tenant::with('admins')->get();
    $admins = Admin::with('tenant')->get();

    return view('superadmin.dashboard', compact('tenants', 'admins'));
}

    // ✅ Show SuperAdmin dashboard
    public function dashboard()
    {
        $admins = Admin::with('tenant')->get(); // Load tenants with admins
        return view('superadmin.dashboard', compact('admins'));
    }
    


    // ✅ Accept a tenant and create its database
    public function acceptTenant($id)
{
    // Find the tenant by ID, or fail if not found
    $tenant = Tenant::findOrFail($id);
    
    // Generate a safe database name based on the tenant's name
    $dbName = 'tenant_' . Str::slug($tenant->name, '_');
    
    // Create the database
    DB::statement("CREATE DATABASE IF NOT EXISTS `$dbName`");
    
    // Update tenant status and other information
    $tenant->update([
        'status' => 'accepted',  // Mark tenant status as accepted
        'database' => $dbName,    // Store the database name
        'is_approved' => true,    // Set the approval status to true
    ]);

    // Send approval email to tenant's admin
    $admin = $tenant->admin; // Assuming there's an 'admin' relationship
    Mail::to($admin->email)->send(new TenantApprovedMail($tenant));

    // Return a success message
    return back()->with('success', 'Tenant accepted, database created, and approval email sent.');
}

    

    // ✅ Approve a tenant and update related admin status
    public function approveTenant($tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
    
        // Create new database
        $databaseName = 'tenant_' . strtolower(str_replace(' ', '_', $tenant->name));
        DB::statement("CREATE DATABASE `$databaseName`");
    
        // Update tenant domain/database and approval status
        $tenant->update([
            'domain' => $databaseName, // or 'database' if you prefer
            'is_approved' => true,     // ✅ add this
            'status' => 'accepted'     // might be missing if only in `acceptTenant`
        ]);
    
        // Accept linked admin accounts
        Admin::where('tenant_id', $tenantId)->update(['status' => 'accepted']);
    
        return back()->with('success', 'Tenant approved and database created successfully.');
    }
    
}
