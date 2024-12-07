<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create parent categories
        ProductCategory::factory()
            ->count(5)
            ->sequence(
                ['name' => 'Electronics', 'slug' => 'electronics'],
                ['name' => 'Clothing', 'slug' => 'clothing'],
                ['name' => 'Home & Garden', 'slug' => 'home-garden'],
                ['name' => 'Sports & Outdoors', 'slug' => 'sports-outdoors'],
                ['name' => 'Books & Media', 'slug' => 'books-media'],
            )
            ->create()
            ->each(function ($category) {
                // Create child categories for each parent
                ProductCategory::factory()
                    ->count(3)
                    ->state(function () use ($category) {
                        return ['parent_id' => $category->id];
                    })
                    ->create();
            });
    }
}
