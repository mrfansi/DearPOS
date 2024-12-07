<?php

namespace Database\Seeders;

use App\Models\ProductPriceList;
use App\Models\ProductPriceListItem;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductPriceListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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

        // Get all active variants
        $variants = ProductVariant::where('is_active', true)->get();

        // Create price list items for each variant
        foreach ($variants as $variant) {
            // Default price list item
            ProductPriceListItem::factory()->create([
                'price_list_id' => $defaultPriceList->id,
                'variant_id' => $variant->id,
                'min_quantity' => 1,
                'price' => $variant->selling_price,
            ]);

            // Wholesale price list items with different quantity breaks
            foreach ([10, 50, 100] as $quantity) {
                $discount = match ($quantity) {
                    10 => 0.90, // 10% discount
                    50 => 0.85, // 15% discount
                    100 => 0.80, // 20% discount
                    default => 1,
                };

                ProductPriceListItem::factory()->create([
                    'price_list_id' => $wholesalePriceList->id,
                    'variant_id' => $variant->id,
                    'min_quantity' => $quantity,
                    'price' => $variant->selling_price * $discount,
                ]);
            }
        }

        // Create some additional price lists
        ProductPriceList::factory()
            ->count(3)
            ->has(ProductPriceListItem::factory()->count(20), 'items')
            ->create();
    }
}
