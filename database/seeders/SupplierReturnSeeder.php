<?php

namespace Database\Seeders;

use App\Models\ProductVariant;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierReturnSeeder extends Seeder
{
    public function run(): void
    {
        // Get a limited number of suppliers and variants
        $suppliers = Supplier::limit(5)->get();

        $variants = ProductVariant::where('is_active', true)
            ->limit(10)
            ->with('product') // Load the product relation
            ->get();

        $returns = [];
        $returnItems = [];
        $now = now();
        $returnNumber = 1;

        foreach ($suppliers as $supplier) {
            // Create only 1 return per supplier
            $return = [
                'id' => fake()->uuid(),
                'supplier_id' => $supplier->id,
                'return_number' => 'RTN-'.str_pad($returnNumber++, 6, '0', STR_PAD_LEFT),
                'return_date' => $now,
                'status' => fake()->randomElement(['draft', 'confirmed', 'cancelled']),
                'notes' => fake()->optional()->sentence(),
                'total_amount' => 0, // Initialize total amount
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $returns[] = $return;

            // Add 2-3 items to each return
            $itemCount = rand(2, 3);
            $returnVariants = $variants->random($itemCount);
            $totalAmount = 0;

            foreach ($returnVariants as $variant) {
                $quantity = rand(1, 5);
                $unitCost = $variant->price ?? 10000; // Default price if not set
                $totalItemAmount = $quantity * $unitCost;
                $totalAmount += $totalItemAmount;

                $returnItems[] = [
                    'id' => fake()->uuid(),
                    'supplier_return_id' => $return['id'],
                    'product_id' => $variant->product->id,
                    'quantity' => $quantity,
                    'unit_cost' => $unitCost,
                    'total_amount' => $totalItemAmount,
                    'reason' => fake()->randomElement(['defective', 'wrong_item', 'damaged']),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Update the total amount for this return
            $returns[count($returns) - 1]['total_amount'] = $totalAmount;
        }

        // Bulk insert returns and items
        DB::table('supplier_returns')->insert($returns);
        DB::table('supplier_return_items')->insert($returnItems);
    }
}
