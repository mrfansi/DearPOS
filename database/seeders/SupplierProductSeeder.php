<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use Illuminate\Database\Seeder;

class SupplierProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get all suppliers and products
        $suppliers = Supplier::all();
        $products = Product::all();

        // Create supplier products with some predefined and some random
        $suppliers->each(function ($supplier) use ($products) {
            // Select a few random products for each supplier
            $selectedProducts = $products->random(rand(3, 7));

            $selectedProducts->each(function ($product) use ($supplier) {
                SupplierProduct::firstOrCreate(
                    [
                        'supplier_id' => $supplier->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'supplier_product_code' => 'SP-'.$supplier->code.'-'.$product->code,
                        'supplier_product_name' => $product->name.' from '.$supplier->name,
                        'unit_cost' => rand(10, 500) / 10,
                        'minimum_order_quantity' => rand(1, 50),
                        'lead_time_days' => rand(1, 30),
                        'is_preferred' => rand(0, 10) < 2, // 20% chance of being preferred
                    ]
                );
            });
        });

        // Add some additional random supplier products
        SupplierProduct::factory()->count(20)->create();
    }
}
