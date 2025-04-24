<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SwitchTenantDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $tenantId = session('tenant_id');
        if ($tenantId) {
            $tenant = Tenant::find($tenantId);
            if ($tenant && $tenant->domain) {
                Config::set('database.connections.tenant.database', $tenant->domain);
                DB::purge('tenant');
                DB::reconnect('tenant');
            }
        }
        return $next($request);


    }
}
