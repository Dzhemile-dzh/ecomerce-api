<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

         // 1. Create 5 categories
        Category::factory()
            ->count(5)
            ->create()
            // 2. For each category, create 10 products:
            ->each(function (Category $category) {
                Product::factory()
                    ->count(10)
                    ->create([
                        'category_id' => $category->id,
                    ]);
            });

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
