<?php

namespace Database\Seeders;

use App\Models\ProductPriceList;
use App\Models\ProductPriceListItem;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPriceListSeeder extends Seeder
{
    public function run(): void
    {
        // Create default price list
        $defaultPriceList = ProductPriceList::factory()
            ->current()
            ->create([
                'name' => 'Default Price List',
                'description' => 'Default retail prices for all products',
            ]);

        // Create wholesale price list
        $wholesalePriceList = ProductPriceList::factory()
            ->current()
            ->create([
                'name' => 'Wholesale Price List',
                'description' => 'Wholesale prices for bulk purchases',
            ]);

        // Get only active variants, limit to 50 variants for testing
        $variants = ProductVariant::where('is_active', true)
            ->limit(50)
            ->get();

        $priceListItems = [];
        $now = now();

        foreach ($variants as $variant) {
            // Default price list item
            $priceListItems[] = [
                'id' => fake()->uuid(),
                'price_list_id' => $defaultPriceList->id,
                'variant_id' => $variant->id,
                'min_quantity' => 1,
                'price' => $variant->selling_price,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Only two quantity breaks instead of three for wholesale
            foreach ([10, 50] as $quantity) {
                $discount = match ($quantity) {
                    10 => 0.90, // 10% discount
                    50 => 0.85, // 15% discount
                    default => 1,
                };

                $priceListItems[] = [
                    'id' => fake()->uuid(),
                    'price_list_id' => $wholesalePriceList->id,
                    'variant_id' => $variant->id,
                    'min_quantity' => $quantity,
                    'price' => $variant->selling_price * $discount,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Bulk insert all price list items
        foreach (array_chunk($priceListItems, 100) as $chunk) {
            DB::table('product_price_list_items')->insert($chunk);
        }

        // Create only 1 additional price list instead of 3
        $additionalPriceList = ProductPriceList::factory()->create();
        
        // Create 10 items instead of 20
        $additionalItems = [];
        for ($i = 0; $i < 10; $i++) {
            $item = ProductPriceListItem::factory()
                ->state(['price_list_id' => $additionalPriceList->id])
                ->make();
            
            $itemArray = $item->toArray();
            $itemArray['id'] = fake()->uuid();
            $additionalItems[] = $itemArray;
        }
        
        DB::table('product_price_list_items')->insert($additionalItems);
    }
}
