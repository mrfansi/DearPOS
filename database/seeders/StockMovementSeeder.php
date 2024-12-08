<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\UnitOfMeasure;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Faker\Factory;

class StockMovementSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Get limited set of data
        $warehouses = Warehouse::where('is_active', true)->limit(3)->get();
        $products = Product::limit(10)->get();
        $units = UnitOfMeasure::all();
        $user = User::first();

        $movementData = [];

        foreach ($warehouses as $warehouse) {
            // Create 5 movements for each product in the warehouse
            foreach ($products->random(5) as $product) {
                $referenceTypes = ['purchase', 'sale', 'transfer', 'adjustment', 'waste'];
                $movementTypes = ['in', 'out', 'transfer', 'adjustment'];

                for ($i = 0; $i < 2; $i++) {
                    $movementType = $faker->randomElement($movementTypes);
                    $referenceType = $faker->randomElement($referenceTypes);

                    $movementData[] = [
                        'id' => $faker->uuid(),
                        'product_id' => $product->id,
                        'product_variant_id' => null, // Simplified: not using variants
                        'warehouse_id' => $warehouse->id,
                        'movement_type' => $movementType,
                        'quantity' => $faker->randomFloat(2, 1, 100),
                        'unit_id' => $units->random()->id,
                        'reference_type' => $referenceType,
                        'reference_id' => $faker->uuid(),
                        'lot_number' => $faker->boolean(30) ? 'LOT-' . strtoupper($faker->bothify('##??')) : null,
                        'expiry_date' => $faker->boolean(30) ? $faker->dateTimeBetween('+1 month', '+1 year') : null,
                        'notes' => $faker->boolean(20) ? $faker->sentence : null,
                        'created_by' => $user->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        // Bulk insert all movements in chunks
        foreach (array_chunk($movementData, 100) as $chunk) {
            StockMovement::insert($chunk);
        }
    }
}
