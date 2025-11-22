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
    }

}
