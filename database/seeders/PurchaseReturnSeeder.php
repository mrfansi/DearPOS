<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PurchaseReturnSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Ensure we have purchase orders to reference
        $purchaseOrders = PurchaseOrder::where('status', 'received')->get();
        if ($purchaseOrders->isEmpty()) {
            $purchaseOrders = PurchaseOrder::factory(5)->create(['status' => 'received']);
        }

        // Ensure we have users to reference
        $users = User::count() > 0 ? User::all() : User::factory(3)->create();

        DB::transaction(function () use ($purchaseOrders, $users, $faker) {
            foreach ($purchaseOrders as $purchaseOrder) {
                // Create returns with different statuses
                $returnStatuses = ['draft', 'pending', 'approved', 'completed', 'cancelled'];

                foreach ($returnStatuses as $status) {
                    $return = PurchaseReturn::factory()->create([
                        'purchase_order_id' => $purchaseOrder->id,
                        'supplier_id' => $purchaseOrder->supplier_id,
                        'status' => $status,
                        'created_by' => $users->random()->id,
                        'approved_by' => in_array($status, ['approved', 'completed']) ? $users->random()->id : null,
                        'approved_at' => in_array($status, ['approved', 'completed']) ? now() : null,
                    ]);

                    // Create return items for each purchase order item
                    $purchaseOrderItems = $purchaseOrder->items;
                    foreach ($purchaseOrderItems as $orderItem) {
                        PurchaseReturnItem::factory()->create([
                            'return_id' => $return->id,
                            'purchase_order_item_id' => $orderItem->id,
                            'quantity' => $status === 'completed' 
                                ? $orderItem->quantity 
                                : $faker->randomFloat(4, 0, $orderItem->quantity)
                        ]);
                    }
                }
            }
        });
    }
}
