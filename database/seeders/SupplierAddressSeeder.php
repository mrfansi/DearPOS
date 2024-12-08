<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\SupplierAddress;
use Illuminate\Database\Seeder;

class SupplierAddressSeeder extends Seeder
{
    public function run(): void
    {
        // Get all suppliers
        $suppliers = Supplier::all();

        $suppliers->each(function ($supplier) {
            // Create a billing address
            SupplierAddress::factory()->create([
                'supplier_id' => $supplier->id,
                'address_type' => 'billing',
                'is_default' => true,
            ]);

            // Create a shipping address
            SupplierAddress::factory()->create([
                'supplier_id' => $supplier->id,
                'address_type' => 'shipping',
            ]);

            // Add some additional random addresses
            SupplierAddress::factory()->count(rand(0, 2))->create([
                'supplier_id' => $supplier->id,
            ]);
        });

        // Add some additional random supplier addresses
        SupplierAddress::factory()->count(10)->create();
    }
}
