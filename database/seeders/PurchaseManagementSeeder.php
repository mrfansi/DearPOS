<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseManagementSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PurchaseOrderSeeder::class,
            PurchaseReceiptSeeder::class,
            PurchaseReturnSeeder::class,
            GoodsReceiptSeeder::class,
            PurchaseAuditSeeder::class,
        ]);
    }
}
