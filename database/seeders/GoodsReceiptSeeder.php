<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptItem;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GoodsReceiptSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Ensure we have purchase orders to reference
        $purchaseOrders = PurchaseOrder::where('status', 'approved')->orWhere('status', 'pending')->get();
        if ($purchaseOrders->isEmpty()) {
            $purchaseOrders = PurchaseOrder::factory(5)->create();
        }

        DB::transaction(function () use ($purchaseOrders, $faker) {
            foreach ($purchaseOrders as $purchaseOrder) {
                // Create goods receipts with different statuses
                $receiptStatuses = ['draft', 'confirmed', 'cancelled'];

                foreach ($receiptStatuses as $status) {
                    $goodsReceipt = GoodsReceipt::create([
                        'id' => $faker->uuid(),
                        'purchase_order_id' => $purchaseOrder->id,
                        'receipt_number' => 'GR-' . $faker->unique()->numberBetween(1000, 9999),
                        'receipt_date' => $faker->date(),
                        'status' => $status,
                        'notes' => $faker->optional()->text(200),
                    ]);

                    // Create goods receipt items for each purchase order item
                    $purchaseOrderItems = $purchaseOrder->items;
                    foreach ($purchaseOrderItems as $orderItem) {
                        GoodsReceiptItem::create([
                            'id' => $faker->uuid(),
                            'goods_receipt_id' => $goodsReceipt->id,
                            'purchase_order_item_id' => $orderItem->id,
                            'product_id' => $orderItem->product_id,
                            'quantity' => $status === 'confirmed' 
                                ? $orderItem->quantity 
                                : $faker->randomFloat(4, 0, $orderItem->quantity),
                            'unit_cost' => $faker->randomFloat(4, 10, 500),
                            'total_amount' => $faker->randomFloat(4, 10, 5000),
                            'notes' => $faker->optional()->text(200),
                        ]);
                    }
                }
            }
        });
    }
}
