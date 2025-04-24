<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $superadmin = Auth::guard('superadmin')->user();
        return view('superadmin.profile.edit', compact('superadmin'));
    }

    public function update(Request $request)
    {
        $superadmin = Auth::guard('superadmin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            // Add other fields and rules here
        ]);

        $superadmin->update($request->only('name'));

        return redirect()->route('superadmin.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
