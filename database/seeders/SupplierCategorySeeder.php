<?php

namespace Database\Seeders;

use App\Models\SupplierCategory;
use Illuminate\Database\Seeder;

class SupplierCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Predefined supplier categories
        $categories = [
            ['name' => 'Raw Materials', 'description' => 'Suppliers of primary production materials'],
            ['name' => 'Electronics', 'description' => 'Electronic components and equipment suppliers'],
            ['name' => 'Office Supplies', 'description' => 'Stationery and office equipment suppliers'],
            ['name' => 'Packaging', 'description' => 'Packaging materials and solutions'],
            ['name' => 'Maintenance', 'description' => 'Maintenance and repair suppliers'],
        ];

        foreach ($categories as $categoryData) {
            SupplierCategory::firstOrCreate(
                ['name' => $categoryData['name']],
                [
                    'description' => $categoryData['description'],
                    'is_active' => true,
                ]
            );
        }

        // Add some random additional categories
        SupplierCategory::factory()->count(5)->create();
    }
}
