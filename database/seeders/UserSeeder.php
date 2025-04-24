<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],

            [
                'name' => 'Super Admin',
                'email' => 'SuperAdmin@example.com',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
            ],

          // [
               // 'name' => 'Pharmacist John',
               // 'email' => 'pharmacist@example.com',
               // 'password' => Hash::make('pharma123'),
              //  'role' => 'pharmacist',
           // ],
            //[
            //    'name' => 'Cashier Jane',
            //    'email' => 'cashier@example.com',
            //    'password' => Hash::make('cashier123'),
            //    'role' => 'cashier',
            //],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
    }
