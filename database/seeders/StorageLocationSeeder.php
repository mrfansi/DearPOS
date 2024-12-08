<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageLocationSeeder extends Seeder
{
    public function run(): void
    {
        // Get only active warehouses, limit to 3
        $warehouses = Warehouse::where('is_active', true)
            ->limit(3)
            ->get();

        $storageLocations = [];
        $now = now();

        foreach ($warehouses as $warehouse) {
            // Create main sections (reduced from many to just 3)
            $sections = ['A', 'B', 'C'];

            static $warehouseCounter = 1;

            foreach ($sections as $section) {
                // Create only 2 aisles per section
                for ($aisle = 1; $aisle <= 2; $aisle++) {
                    // Create only 2 racks per aisle
                    for ($rack = 1; $rack <= 2; $rack++) {
                        // Create only 2 levels per rack
                        for ($level = 1; $level <= 2; $level++) {
                            // Make the location code unique by using a counter for each warehouse
                            $locationCode = sprintf('W%d-%s-%02d-%02d-%02d',
                                $warehouseCounter,
                                $section,
                                $aisle,
                                $rack,
                                $level);

                            $storageLocations[] = [
                                'id' => fake()->uuid(),
                                'warehouse_id' => $warehouse->id,
                                'name' => sprintf('Location %s', $locationCode),
                                'code' => $locationCode,
                                'description' => sprintf('Storage location in section %s, aisle %d, rack %d, level %d',
                                    $section, $aisle, $rack, $level),
                                'is_active' => true,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }
                }
            }
            $warehouseCounter++;
        }

        // Bulk insert storage locations in chunks
        foreach (array_chunk($storageLocations, 50) as $chunk) {
            DB::table('storage_locations')->insert($chunk);
        }
    }
}
