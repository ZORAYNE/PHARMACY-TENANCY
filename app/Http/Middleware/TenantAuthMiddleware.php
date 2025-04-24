<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TenantAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant_id = $request->route('tenant_id');

        $isExcludedRoute = $request->routeIs('tenant.selector') ||
                           $request->routeIs('tenant.selector.redirect') ||
                           $request->routeIs('tenant.login') ||
                           $request->routeIs('tenant.login.submit');

        $shouldRedirectToTenantSelector = !$tenant_id && !$isExcludedRoute;
        $shouldRedirectToLogin = !$isExcludedRoute && (!Auth::check() || Auth::user()->role !== 'tenant');

        if ($shouldRedirectToTenantSelector) {
            return redirect('/tenant-selector')->withErrors(['Tenant ID is missing.']);
        }

        if ($shouldRedirectToLogin) {
            return redirect()->route('tenant.login', ['tenant_id' => $tenant_id])
                             ->withErrors(['Access denied.']);
        }

        \Log::info('Tenant ID:', ['tenant_id' => $tenant_id]);

        return $next($request);
    }
}
