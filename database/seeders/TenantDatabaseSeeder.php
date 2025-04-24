<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Example seed data for products
          DB::table('products')->insert([
            ['name' => 'Paracetamol', 'price' => 50, 'stock' => 100],
            ['name' => 'Ibuprofen', 'price' => 75, 'stock' => 80],
            ['name' => 'Vitamin C', 'price' => 40, 'stock' => 150],
        ]);
    }
}
