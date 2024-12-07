<?php

namespace Database\Seeders;

use App\Models\ProductBrand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Apple' => 'https://www.apple.com',
            'Samsung' => 'https://www.samsung.com',
            'Nike' => 'https://www.nike.com',
            'Adidas' => 'https://www.adidas.com',
            'Sony' => 'https://www.sony.com',
            'LG' => 'https://www.lg.com',
            'HP' => 'https://www.hp.com',
            'Dell' => 'https://www.dell.com',
            'Lenovo' => 'https://www.lenovo.com',
            'Asus' => 'https://www.asus.com',
        ];

        foreach ($brands as $name => $website) {
            ProductBrand::factory()->create([
                'name' => $name,
                'slug' => Str::slug($name),
                'website' => $website,
                'is_active' => true,
            ]);
        }

        // Create some additional random brands
        ProductBrand::factory()->count(10)->create();
    }
}
