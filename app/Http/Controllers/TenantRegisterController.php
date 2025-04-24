<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Stancl\Tenancy\TenantManager;
use Illuminate\Support\Str;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class TenantRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('tenants.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tenants,id',
            'email' => 'required|email|unique:users,email',
        ]);

        $tenant = Tenant::create([
            'id' => $request->name,
            'tenancy_db_name' => 'tenant_' . $request->name,
        ]);

        $tenant->domains()->create([
            'domain' => $request->name . '.localhost', // or .test/.dev
        ]);

        return redirect('http://' . $request->name . '.localhost');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenant_name' => 'required|unique:tenants,name',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $tenant = Tenant::create([
            'name' => $request->tenant_name,
            'domain' => null,
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tenant_id' => $tenant->id,
            'status' => 'pending',
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'Tenant registered successfully. Awaiting SuperAdmin approval.');
    }
}
