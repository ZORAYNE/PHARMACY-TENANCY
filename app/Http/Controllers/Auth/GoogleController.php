<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if the user already exists in the database
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // If user does not exist, create a new one
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt('password'), // Use a default password
                'role' => 'tenant', // Set role to tenant
            ]);
        }

        // Log the user in
        Auth::login($user, true);

        return redirect()->route('dashboard'); // Redirect to the desired route
    }
}
