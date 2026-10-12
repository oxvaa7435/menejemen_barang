<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        // Seed Products
        \App\Models\Product::create([
            'code' => 'MAT-001',
            'name' => 'Laptop ASUS',
            'unit' => 'ROL',
            'description' => 'High performance laptop',
            'stock' => 10,
        ]);

        \App\Models\Product::create([
            'code' => 'MAT-002',
            'name' => 'Mouse Logitech',
            'unit' => 'lembar',
            'description' => 'Wireless mouse',
            'stock' => 50,
        ]);

        \App\Models\Product::create([
            'code' => 'MAT-003',
            'name' => 'Office Chair',
            'unit' => 'KG',
            'description' => 'Ergonomic chair',
            'stock' => 15,
        ]);
    }
}
