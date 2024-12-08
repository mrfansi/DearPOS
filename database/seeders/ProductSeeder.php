<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Reduce the number of products and use chunk insert
        
        // Simple products (reduced from 20 to 10)
        $simpleProducts = Product::factory()
            ->count(10)
            ->state(['type' => 'simple'])
            ->create();

        $simpleVariants = [];
        $simpleImages = [];

        foreach ($simpleProducts as $product) {
            $variant = ProductVariant::factory()
                ->state(['is_active' => true, 'product_id' => $product->id])
                ->make();
            
            $variantArray = $variant->toArray();
            $variantArray['id'] = fake()->uuid(); // Add UUID
            $simpleVariants[] = $variantArray;
            
            // 1 image per variant instead of 2
            $image = ProductImage::factory()
                ->state([
                    'product_id' => $product->id,
                    'variant_id' => $variantArray['id']
                ])
                ->make();
            
            $imageArray = $image->toArray();
            $imageArray['id'] = fake()->uuid(); // Add UUID
            $simpleImages[] = $imageArray;
        }

        // Bulk insert variants and images
        DB::table('product_variants')->insert($simpleVariants);
        DB::table('product_images')->insert($simpleImages);

        // Variant products (reduced from 30 to 15)
        $variantProducts = Product::factory()
            ->count(15)
            ->state(['type' => 'variant'])
            ->create();

        $variantProductVariants = [];
        $variantAttributes = [];
        $variantImages = [];

        foreach ($variantProducts as $product) {
            // 2 variants per product instead of 3
            for ($i = 0; $i < 2; $i++) {
                $variant = ProductVariant::factory()
                    ->state([
                        'is_active' => true,
                        'product_id' => $product->id
                    ])
                    ->make();
                
                $variantArray = $variant->toArray();
                $variantArray['id'] = fake()->uuid(); // Add UUID
                $variantProductVariants[] = $variantArray;

                // 1 attribute per variant instead of 2
                $attribute = ProductVariantAttribute::factory()
                    ->state([
                        'variant_id' => $variantArray['id']
                    ])
                    ->make();
                
                $attributeArray = $attribute->toArray();
                $attributeArray['id'] = fake()->uuid(); // Add UUID
                $variantAttributes[] = $attributeArray;

                // 1 image per variant instead of 2
                $image = ProductImage::factory()
                    ->state([
                        'product_id' => $product->id,
                        'variant_id' => $variantArray['id']
                    ])
                    ->make();
                
                $imageArray = $image->toArray();
                $imageArray['id'] = fake()->uuid(); // Add UUID
                $variantImages[] = $imageArray;
            }

            // 1 product-level image instead of 2
            $productImage = ProductImage::factory()
                ->state([
                    'product_id' => $product->id,
                    'variant_id' => null
                ])
                ->make();
            
            $imageArray = $productImage->toArray();
            $imageArray['id'] = fake()->uuid(); // Add UUID
            $variantImages[] = $imageArray;
        }

        // Bulk insert all variant-related data
        DB::table('product_variants')->insert($variantProductVariants);
        DB::table('product_variant_attributes')->insert($variantAttributes);
        DB::table('product_images')->insert($variantImages);

        // Service products (reduced from 10 to 5)
        $serviceProducts = Product::factory()
            ->count(5)
            ->state(['type' => 'service'])
            ->create();

        $serviceVariants = [];
        foreach ($serviceProducts as $product) {
            $variant = ProductVariant::factory()
                ->state([
                    'is_active' => true,
                    'product_id' => $product->id
                ])
                ->make();
            
            $variantArray = $variant->toArray();
            $variantArray['id'] = fake()->uuid(); // Add UUID
            $serviceVariants[] = $variantArray;
        }

        DB::table('product_variants')->insert($serviceVariants);
    }
}
