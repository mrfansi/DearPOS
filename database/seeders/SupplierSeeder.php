<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        // Predefined suppliers
        $suppliers = [
            [
                'code' => 'SUP001',
                'name' => 'Global Materials Inc.',
                'company_name' => 'Global Materials Corporation',
                'email' => 'contact@globalmaterials.com',
                'phone' => '+1-555-123-4567',
                'status' => 'active'
            ],
            [
                'code' => 'SUP002',
                'name' => 'Tech Components Ltd.',
                'company_name' => 'Tech Components Limited',
                'email' => 'sales@techcomponents.com',
                'phone' => '+1-555-987-6543',
                'status' => 'active'
            ],
            [
                'code' => 'SUP003',
                'name' => 'Office Supplies Direct',
                'company_name' => 'Office Supplies Direct Inc.',
                'email' => 'orders@officesupplies.com',
                'phone' => '+1-555-246-8101',
                'status' => 'active'
            ]
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::firstOrCreate(
                ['code' => $supplierData['code']],
                $supplierData
            );
        }

        // Add some random additional suppliers
        Supplier::factory()->count(10)->create();
    }
};
