<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockAlert;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Faker\Factory;

class StockAlertSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Get limited set of data
        $warehouses = Warehouse::where('is_active', true)->limit(3)->get();
        $products = Product::limit(10)->get();
        $user = User::first();

        $alertData = [];

        // Create alerts for each warehouse
        foreach ($warehouses as $warehouse) {
            // Create low stock alerts
            foreach ($products->random(2) as $product) {
                $threshold = $faker->randomFloat(2, 10, 50);
                $alertData[] = [
                    'id' => $faker->uuid(),
                    'product_id' => $product->id,
                    'product_variant_id' => null,
                    'warehouse_id' => $warehouse->id,
                    'alert_type' => 'low_stock',
                    'threshold_quantity' => $threshold,
                    'current_quantity' => $faker->randomFloat(2, 0, $threshold - 1),
                    'status' => $faker->randomElement(['active', 'resolved']),
                    'is_notification_sent' => $faker->boolean(70),
                    'notification_date' => now()->subDays(rand(1, 7)),
                    'resolved_by' => $faker->boolean(30) ? $user->id : null,
                    'resolved_at' => $faker->boolean(30) ? now()->subDays(rand(1, 3)) : null,
                    'notes' => $faker->boolean(20) ? $faker->sentence : null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Create overstock alerts
            foreach ($products->random(2) as $product) {
                $threshold = $faker->randomFloat(2, 100, 200);
                $alertData[] = [
                    'id' => $faker->uuid(),
                    'product_id' => $product->id,
                    'product_variant_id' => null,
                    'warehouse_id' => $warehouse->id,
                    'alert_type' => 'overstock',
                    'threshold_quantity' => $threshold,
                    'current_quantity' => $faker->randomFloat(2, $threshold + 1, $threshold + 100),
                    'status' => $faker->randomElement(['active', 'resolved']),
                    'is_notification_sent' => $faker->boolean(70),
                    'notification_date' => now()->subDays(rand(1, 7)),
                    'resolved_by' => $faker->boolean(30) ? $user->id : null,
                    'resolved_at' => $faker->boolean(30) ? now()->subDays(rand(1, 3)) : null,
                    'notes' => $faker->boolean(20) ? $faker->sentence : null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // Create expiring alerts
            foreach ($products->random(1) as $product) {
                $alertData[] = [
                    'id' => $faker->uuid(),
                    'product_id' => $product->id,
                    'product_variant_id' => null,
                    'warehouse_id' => $warehouse->id,
                    'alert_type' => 'expiring',
                    'threshold_quantity' => null,
                    'current_quantity' => $faker->randomFloat(2, 1, 100),
                    'status' => $faker->randomElement(['active', 'resolved']),
                    'is_notification_sent' => $faker->boolean(70),
                    'notification_date' => now()->subDays(rand(1, 7)),
                    'resolved_by' => $faker->boolean(30) ? $user->id : null,
                    'resolved_at' => $faker->boolean(30) ? now()->subDays(rand(1, 3)) : null,
                    'notes' => $faker->boolean(20) ? $faker->sentence : null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        // Bulk insert all alerts
        foreach (array_chunk($alertData, 100) as $chunk) {
            StockAlert::insert($chunk);
        }
    }
}
