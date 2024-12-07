<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main store location
        Location::factory()->asStore()->create([
            'code' => 'MAIN-001',
            'name' => 'Main Store',
            'address' => 'Jl. Raya Utama No. 123',
            'city' => 'Jakarta',
            'state' => 'DKI Jakarta',
            'country' => 'Indonesia',
            'postal_code' => '12345',
            'phone' => '(021) 555-0123',
            'email' => 'main.store@dearpos.com',
            'is_active' => true,
        ]);

        // Create warehouse location
        Location::factory()->asWarehouse()->create([
            'code' => 'WH-001',
            'name' => 'Central Warehouse',
            'address' => 'Jl. Industri Raya No. 45',
            'city' => 'Tangerang',
            'state' => 'Banten',
            'country' => 'Indonesia',
            'postal_code' => '15710',
            'phone' => '(021) 555-0124',
            'email' => 'warehouse@dearpos.com',
            'is_active' => true,
        ]);

        // Create branch store locations
        $branches = [
            [
                'code' => 'BR-001',
                'name' => 'Branch Store Kemang',
                'address' => 'Jl. Kemang Raya No. 88',
                'city' => 'Jakarta Selatan',
                'state' => 'DKI Jakarta',
                'country' => 'Indonesia',
                'postal_code' => '12730',
                'phone' => '(021) 555-0125',
                'email' => 'kemang@dearpos.com',
            ],
            [
                'code' => 'BR-002',
                'name' => 'Branch Store Kelapa Gading',
                'address' => 'Jl. Boulevard Raya No. 55',
                'city' => 'Jakarta Utara',
                'state' => 'DKI Jakarta',
                'country' => 'Indonesia',
                'postal_code' => '14240',
                'phone' => '(021) 555-0126',
                'email' => 'kelapagading@dearpos.com',
            ],
        ];

        foreach ($branches as $branch) {
            Location::factory()->asStore()->create(array_merge($branch, ['is_active' => true]));
        }

        // Create some random locations
        Location::factory()->count(5)->create();
    }
}
