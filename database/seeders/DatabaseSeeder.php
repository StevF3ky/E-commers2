<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        
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
