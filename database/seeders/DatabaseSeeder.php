<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // create admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);


        // Create 5 categories
        Category::factory()
            ->count(5)
            ->create()
            ->each(function ($category) {
                // For each category, create 5 products
                Product::factory()->count(5)->create([
                    'category_id' => $category->id,
                ]);
            });


    }
}
