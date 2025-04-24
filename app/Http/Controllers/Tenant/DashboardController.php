<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant;

class DashboardController extends Controller
{
    public function dashboard($tenantId)
    {
        $tenant = Tenant::findOrFail($tenantId);
        return view('tenants.dashboard', compact('tenant'));
    }

    public function showDashboard() {
        return view('dashboard')->with([
            'layout' => 'layouts.tenant-navigation',
        ]);
    }
}
