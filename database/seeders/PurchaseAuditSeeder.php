<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReturn;
use App\Models\PurchaseAudit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PurchaseAuditSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        // Ensure we have purchase orders and returns to reference
        $purchaseOrders = PurchaseOrder::all();
        $purchaseReturns = PurchaseReturn::all();

        if ($purchaseOrders->isEmpty()) {
            $purchaseOrders = PurchaseOrder::factory(5)->create();
        }

        if ($purchaseReturns->isEmpty()) {
            $purchaseReturns = PurchaseReturn::factory(3)->create();
        }

        // Ensure we have users to reference
        $users = User::count() > 0 ? User::all() : User::factory(3)->create();

        DB::transaction(function () use ($purchaseOrders, $purchaseReturns, $users, $faker) {
            // Audit for Purchase Orders
            foreach ($purchaseOrders as $purchaseOrder) {
                $auditEvents = ['created', 'updated', 'status_changed'];

                foreach ($auditEvents as $event) {
                    PurchaseAudit::factory()->create([
                        'auditable_type' => PurchaseOrder::class,
                        'auditable_id' => $purchaseOrder->id,
                        'event' => $event,
                        'user_id' => $users->random()->id,
                    ]);
                }
            }

            // Audit for Purchase Returns
            foreach ($purchaseReturns as $purchaseReturn) {
                $auditEvents = ['created', 'updated', 'status_changed'];

                foreach ($auditEvents as $event) {
                    PurchaseAudit::factory()->create([
                        'auditable_type' => PurchaseReturn::class,
                        'auditable_id' => $purchaseReturn->id,
                        'event' => $event,
                        'user_id' => $users->random()->id,
                    ]);
                }
            }
        });
    }
}
