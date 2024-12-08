<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockTransfer;
use App\Models\StockTransferItem;
use App\Models\UnitOfMeasure;
use App\Models\User;
use App\Models\Warehouse;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StockTransferSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Get limited set of data
        $warehouses = Warehouse::where('is_active', true)->limit(3)->get();
        $products = Product::limit(10)->get();
        $units = UnitOfMeasure::all();
        $user = User::first();

        $transferData = [];
        $transferItemData = [];

        // Create 5 transfers
        for ($i = 0; $i < 5; $i++) {
            // Get random source and destination warehouses
            $sourceWarehouse = $warehouses->random();
            $destinationWarehouse = $warehouses->where('id', '!=', $sourceWarehouse->id)->random();

            $status = $faker->randomElement(['draft', 'pending', 'completed']);
            $transferDate = now()->subDays(rand(0, 30));

            $transferId = $faker->uuid();

            $transferData[] = [
                'id' => $transferId,
                'transfer_number' => 'TRF-'.strtoupper(substr(uniqid(), -8)),
                'source_warehouse_id' => $sourceWarehouse->id,
                'destination_warehouse_id' => $destinationWarehouse->id,
                'status' => $status,
                'transfer_date' => $transferDate,
                'notes' => $faker->boolean(30) ? $faker->sentence : null,
                'created_by' => $user->id,
                'approved_by' => $status !== 'draft' ? $user->id : null,
                'approved_at' => $status !== 'draft' ? $transferDate : null,
                'completed_by' => $status === 'completed' ? $user->id : null,
                'completed_at' => $status === 'completed' ? $transferDate->addHours(2) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Create 2-3 items for each transfer
            foreach ($products->random(rand(2, 3)) as $product) {
                $quantityRequested = $faker->randomFloat(2, 1, 100);

                $transferItemData[] = [
                    'id' => $faker->uuid(),
                    'transfer_id' => $transferId,
                    'product_id' => $product->id,
                    'product_variant_id' => null,
                    'quantity_requested' => $quantityRequested,
                    'quantity_sent' => $status !== 'draft' ? $faker->randomFloat(2, 0, $quantityRequested) : null,
                    'quantity_received' => $status === 'completed' ? $faker->randomFloat(2, 0, $quantityRequested) : null,
                    'unit_id' => $units->random()->id,
                    'lot_number' => $faker->boolean(30) ? 'LOT-'.strtoupper($faker->bothify('##??')) : null,
                    'expiry_date' => $faker->boolean(30) ? $faker->dateTimeBetween('+1 month', '+1 year') : null,
                    'notes' => $faker->boolean(20) ? $faker->sentence : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Bulk insert all transfers and items
        foreach (array_chunk($transferData, 100) as $chunk) {
            StockTransfer::insert($chunk);
        }

        foreach (array_chunk($transferItemData, 100) as $chunk) {
            StockTransferItem::insert($chunk);
        }
    }
}
