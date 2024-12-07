<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\SupplierContact;
use Illuminate\Database\Seeder;

class SupplierContactSeeder extends Seeder
{
    public function run(): void
    {
        // Get all suppliers
        $suppliers = Supplier::all();

        $suppliers->each(function ($supplier) {
            // Create a primary contact
            SupplierContact::factory()->create([
                'supplier_id' => $supplier->id,
                'is_primary' => true
            ]);

            // Add some additional random contacts
            SupplierContact::factory()->count(rand(1, 3))->create([
                'supplier_id' => $supplier->id
            ]);
        });

        // Add some additional random supplier contacts
        SupplierContact::factory()->count(10)->create();
    }
};
