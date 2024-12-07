<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create simple products
        Product::factory()
            ->count(20)
            ->state(['type' => 'simple'])
            ->has(
                ProductVariant::factory()
                    ->count(1)
                    ->state(['is_active' => true])
                    ->has(
                        ProductImage::factory()
                            ->count(2)
                            ->state(fn ($attributes, ProductVariant $variant) => [
                                'product_id' => $variant->product_id,
                            ]),
                        'images'
                    ),
                'variants'
            )
            ->create();

        // Create variant products
        Product::factory()
            ->count(30)
            ->state(['type' => 'variant'])
            ->has(
                ProductVariant::factory()
                    ->count(3)
                    ->state(['is_active' => true])
                    ->has(ProductVariantAttribute::factory()->count(2), 'attributes')
                    ->has(
                        ProductImage::factory()
                            ->count(2)
                            ->state(fn ($attributes, ProductVariant $variant) => [
                                'product_id' => $variant->product_id,
                            ]),
                        'images'
                    ),
                'variants'
            )
            ->create()
            ->each(function ($product) {
                // Add some product-level images
                ProductImage::factory()
                    ->count(2)
                    ->state(['product_id' => $product->id, 'variant_id' => null])
                    ->create();
            });

        // Create service products
        Product::factory()
            ->count(10)
            ->state(['type' => 'service'])
            ->has(
                ProductVariant::factory()
                    ->count(1)
                    ->state(['is_active' => true]),
                'variants'
            )
            ->create();
    }
}
