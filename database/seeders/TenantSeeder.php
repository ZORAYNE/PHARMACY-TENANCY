<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use App\Mail\TenantApprovedMail;
use Illuminate\Support\Facades\Mail;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create or update some sample tenants
        $tenant1 = Tenant::updateOrCreate(
            ['domain' => 'tenant1.example.com'],
            ['name' => 'Tenant 1']
        );

        $tenant2 = Tenant::updateOrCreate(
            ['domain' => 'tenant2.example.com'],
            ['name' => 'Tenant 2']
        );

        $tenant3 = Tenant::updateOrCreate(
            ['domain' => 'tenant3.example.com'],
            ['name' => 'Tenant 3']
        );

        $tenant4 = Tenant::updateOrCreate(
            ['domain' => 'tenant4.example.com'],
            ['name' => 'Tenant 4']
        );

        $tenant5 = Tenant::updateOrCreate(
            ['domain' => 'tenant5.example.com'],
            ['name' => 'Tenant 5']
        );

        // Create or update associated admins for each tenant
        Admin::updateOrCreate(
            ['email' => 'kithalforque@gmail.com'],
            [
                'name' => 'Admin 1',
                'password' => Hash::make('password123'),
                'tenant_id' => $tenant1->id,
                'status' => 'accepted',
            ]
        );

        Admin::updateOrCreate(
            ['email' => '1901101887@student.buksu.edu.ph'],
            [
                'name' => 'Admin 2',
                'password' => Hash::make('password123'),
                'tenant_id' => $tenant2->id,
                'status' => 'accepted',
            ]
        );

        Admin::updateOrCreate(
            ['email' => '2201104469@student.buksu.edu.ph'],
            [
                'name' => 'Admin 3',
                'password' => Hash::make('password123'),
                'tenant_id' => $tenant3->id,
                'status' => 'accepted',
            ]
        );

        Admin::updateOrCreate(
            ['email' => '2201110118@student.buksu.edu.ph'],
            [
                'name' => 'Admin 4',
                'password' => Hash::make('password123'),
                'tenant_id' => $tenant4->id,
                'status' => 'accepted',
            ]
        );
        Admin::updateOrCreate(
            ['email' => '2001101135@student.buksu.edu.ph'],
            [
                'name' => 'Admin 5',
                'password' => Hash::make('password123'),
                'tenant_id' => $tenant5->id,
                'status' => 'accepted',
            ]
        );
          // Send approval emails for all tenants that are accepted
        $admins = Admin::where('status', 'accepted')->get(); // Fetch all accepted admins
        foreach ($admins as $admin) {
            // Get the tenant linked to the admin
            $tenant = $admin->tenant;
            // Send email to the admin about tenant approval
            Mail::to($admin->email)->send(new TenantApprovedMail($tenant));
        }
    }
}
