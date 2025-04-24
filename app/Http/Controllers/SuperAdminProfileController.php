<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperAdminProfileController extends Controller
{
    public function edit()
    {
        return view('superadmin.profile.edit');
    }
}
