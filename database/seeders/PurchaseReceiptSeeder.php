<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceipt;
use App\Models\PurchaseReceiptItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PurchaseReceiptSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Ensure we have purchase orders to reference
        $purchaseOrders = PurchaseOrder::where('status', 'approved')->orWhere('status', 'pending')->get();
        if ($purchaseOrders->isEmpty()) {
            $purchaseOrders = PurchaseOrder::factory(5)->create();
        }

        // Ensure we have users to reference
        $users = User::count() > 0 ? User::all() : User::factory(3)->create();

        DB::transaction(function () use ($purchaseOrders, $users, $faker) {
            foreach ($purchaseOrders as $purchaseOrder) {
                // Create receipts with different statuses
                $receiptStatuses = ['draft', 'confirmed', 'cancelled'];

                foreach ($receiptStatuses as $status) {
                    $receipt = PurchaseReceipt::factory()->create([
                        'purchase_order_id' => $purchaseOrder->id,
                        'status' => $status,
                        'received_by' => $users->random()->id,
                    ]);

                    // Create receipt items for each purchase order item
                    $purchaseOrderItems = $purchaseOrder->items;
                    foreach ($purchaseOrderItems as $orderItem) {
                        PurchaseReceiptItem::factory()->create([
                            'receipt_id' => $receipt->id,
                            'purchase_order_item_id' => $orderItem->id,
                            'quantity_received' => $status === 'confirmed' 
                                ? $orderItem->quantity 
                                : $faker->randomFloat(4, 0, $orderItem->quantity)
                        ]);
                    }
                }
            }
        });
    }
}
