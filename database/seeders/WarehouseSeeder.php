<?php

namespace Database\Seeders;

use App\Models\StorageLocation;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 warehouses with storage locations
        Warehouse::factory()
            ->count(5)
            ->create()
            ->each(function (Warehouse $warehouse) {
                // Create 3-8 storage locations for each warehouse
                StorageLocation::factory()
                    ->count(rand(3, 8))
                    ->forWarehouse($warehouse)
                    ->create();
            });
    }
}
