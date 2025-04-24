<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('superadmin.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            // Check if the user is a tenant or superadmin
            if (Auth::check() && Auth::user()->role === 'superadmin') {
                return redirect()->route('superadmin.dashboard');  // Redirect to the super admin dashboard
            }
    
            return redirect()->route('tenant.dashboard', ['tenant_id' => Auth::user()->tenant_id]);
            // Redirect to the specific tenant dashboard
        }
    
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
