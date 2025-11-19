<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Category::create(['name' => 'Makanan']);
        Category::create(['name' => 'Pakaian']);
        Category::create(['name' => 'Elektronik']);
        Category::create(['name' => 'Lain-lain']);
        

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => User::ROLE_ADMIN,
        ]);

        user::factory()->create([
            'name' => 'Seller',
            'email' => 'seller@gmail.com',
            'role' => User::ROLE_SELLER,
            'password' => 'seller123',
        ]);

    }

}
