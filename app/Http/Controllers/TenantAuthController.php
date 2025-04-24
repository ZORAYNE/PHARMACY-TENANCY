<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class TenantAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if tenant already exists by domain (or email)
        $existingTenant = Tenant::where('domain', $googleUser->email)->first();

        // If tenant does not exist, create a new one
        if (!$existingTenant) {
            // Create new tenant
            $tenant = Tenant::create([
                'name' => $googleUser->name,
                'domain' => $googleUser->email, // Use the email as a domain reference
            ]);

            // Create admin for the newly created tenant
            Admin::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Hash::make('password123'), // Consider generating a random password or using a stronger password
                'tenant_id' => $tenant->id,
                'status' => 'pending', // Set status to 'pending' for approval
            ]);

            // Send email with the tenant's site link
            $siteLink = url('/tenant/' . $tenant->id); // The URL to the tenant dashboard or site link
            Mail::raw("Welcome {$googleUser->name}, your pharmacy site link: {$siteLink}", function ($message) use ($googleUser) {
                $message->to($googleUser->email)
                        ->subject('Your Pharmacy Site Link');
            });

            // Optionally, you could redirect to a tenant-specific registration confirmation page
            return redirect()->route('register')->with('status', 'Registration successful! Please check your email.');
        }

        // If the tenant already exists, proceed with login or some other flow
        return redirect('/')->with('status', 'Tenant already exists. Proceed to login.');
    }
}
