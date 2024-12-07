<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\SupplierReturn;
use Illuminate\Database\Seeder;

class SupplierReturnSeeder extends Seeder
{
    public function run(): void
    {
        // Get all suppliers
        $suppliers = Supplier::all();

        $suppliers->each(function ($supplier) {
            // Create draft supplier returns
            SupplierReturn::factory()
                ->count(2)
                ->draft()
                ->create([
                    'supplier_id' => $supplier->id
                ]);

            // Create confirmed supplier returns
            SupplierReturn::factory()
                ->count(1)
                ->confirmed()
                ->create([
                    'supplier_id' => $supplier->id
                ]);
        });

        // Add some additional random supplier returns
        SupplierReturn::factory()->count(10)->create();
    }
};
