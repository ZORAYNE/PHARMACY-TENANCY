<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Tenant;
use Illuminate\Support\Str;



class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        $tenant = Tenant::create([
            'name' => $request->name,
            'domain' => strtolower(str_replace(' ', '', $request->name)) . '.yourdomain.com',
            'status' => 'pending',
        ]);
    
        $user->tenant_id = $tenant->id;
        $user->save();

                // Create Tenant entry (status pending)
        $tenant = Tenant::create([
            'name' => $request->tenant_name,
            'domain' => Str::slug($request->tenant_name) . '.example.com',
            'status' => 'pending', // or whatever your approval logic is
        ]);

        // Optionally associate tenant ID with admin
        $user->tenant_id = $tenant->id;
        $user->save();

    
        event(new Registered($user));
    
        Auth::login($user);
    
        return redirect(RouteServiceProvider::HOME);
    }
    public function showRegistrationForm()
    {
        $tenants = Tenant::all(); // Fetch all tenants
        return view('auth.register', compact('tenants'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'tenant_name' => 'required',
            'tenant_id' => 'required|exists:tenants,id',  // Validating tenant ID
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Create user
        $user = User::create([
            'tenant_id' => $request->tenant_id, // Associate the user with the selected tenant
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Perform login or other actions as needed
        auth()->login($user);

        return redirect()->route('dashboard'); // Redirect to the dashboard or another page
    }

    
}
