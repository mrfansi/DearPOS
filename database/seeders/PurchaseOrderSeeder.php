<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Currency;
use App\Models\User;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PurchaseOrderSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Ensure we have some base data to reference
        $suppliers = Supplier::count() > 0 ? Supplier::all() : Supplier::factory(3)->create();
        $warehouses = Warehouse::count() > 0 ? Warehouse::all() : Warehouse::factory(2)->create();
        $currencies = Currency::count() > 0 ? Currency::all() : Currency::factory(2)->create();
        $users = User::count() > 0 ? User::all() : User::factory(5)->create();

        // Create purchase orders with different statuses
        $purchaseOrders = [
            // Draft Purchase Orders
            [
                'status' => 'draft',
                'quantity_items' => 2,
                'approved' => false
            ],
            // Pending Purchase Orders
            [
                'status' => 'pending',
                'quantity_items' => 3,
                'approved' => false
            ],
            // Approved Purchase Orders
            [
                'status' => 'approved',
                'quantity_items' => 4,
                'approved' => true
            ],
            // Received Purchase Orders
            [
                'status' => 'received',
                'quantity_items' => 3,
                'approved' => true
            ],
            // Cancelled Purchase Orders
            [
                'status' => 'cancelled',
                'quantity_items' => 1,
                'approved' => false
            ]
        ];

        DB::transaction(function () use ($purchaseOrders, $suppliers, $warehouses, $currencies, $users, $faker) {
            foreach ($purchaseOrders as $orderConfig) {
                $supplier = $suppliers->random();
                $warehouse = $warehouses->random();
                $currency = $currencies->random();
                $createdBy = $users->random();
                $approvedBy = $orderConfig['approved'] ? $users->random() : null;

                $totalAmount = 0;
                $taxAmount = 0;
                $discountAmount = 0;

                $purchaseOrder = PurchaseOrder::factory()->create([
                    'supplier_id' => $supplier->id,
                    'warehouse_id' => $warehouse->id,
                    'currency_id' => $currency->id,
                    'status' => $orderConfig['status'],
                    'created_by' => $createdBy->id,
                    'approved_by' => $approvedBy ? $approvedBy->id : null,
                    'approved_at' => $approvedBy ? now() : null,
                ]);

                // Create Purchase Order Items
                for ($i = 0; $i < $orderConfig['quantity_items']; $i++) {
                    $orderItem = PurchaseOrderItem::factory()->create([
                        'purchase_order_id' => $purchaseOrder->id,
                    ]);

                    $totalAmount += $orderItem->total_amount;
                    $taxAmount += $orderItem->tax_amount;
                    $discountAmount += $orderItem->discount_amount;
                }

                // Update Purchase Order totals
                $purchaseOrder->update([
                    'total_amount' => $totalAmount,
                    'tax_amount' => $taxAmount,
                    'discount_amount' => $discountAmount,
                    'shipping_amount' => $faker->randomFloat(4, 10, 100),
                    'grand_total' => $totalAmount + $taxAmount - $discountAmount
                ]);
            }
        });
    }
}
