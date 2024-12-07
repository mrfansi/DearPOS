<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\PosCounter;
use Illuminate\Database\Seeder;

class PosCounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create locations
        $mainLocation = Location::firstOrCreate([
            'code' => 'MAIN-STORE-01',
            'name' => 'Main Store',
            'address' => '123 Main St',
            'city' => 'Cityville',
            'state' => 'CA',
            'country' => 'United States',
            'postal_code' => '90210',
            'phone' => '+1-555-123-4567',
            'email' => 'mainstore@example.com',
            'type' => 'store',
        ]);

        $branchLocation = Location::firstOrCreate([
            'code' => 'BRANCH-STORE-01',
            'name' => 'Branch Store',
            'address' => '456 Branch Ave',
            'city' => 'Townsville',
            'state' => 'NY',
            'country' => 'United States',
            'postal_code' => '10001',
            'phone' => '+1-555-987-6543',
            'email' => 'branchstore@example.com',
            'type' => 'store',
        ]);

        // Create POS counters for main location
        PosCounter::factory()->createMany([
            [
                'code' => 'MAIN-01',
                'name' => 'Main Store - Counter 1',
                'location_id' => $mainLocation->id,
            ],
            [
                'code' => 'MAIN-02',
                'name' => 'Main Store - Counter 2',
                'location_id' => $mainLocation->id,
            ],
            [
                'code' => 'MAIN-03',
                'name' => 'Main Store - Express Checkout',
                'location_id' => $mainLocation->id,
            ]
        ]);

        // Create POS counters for branch location
        PosCounter::factory()->createMany([
            [
                'code' => 'BRANCH-01',
                'name' => 'Branch Store - Main Counter',
                'location_id' => $branchLocation->id,
            ],
            [
                'code' => 'BRANCH-02',
                'name' => 'Branch Store - Customer Service',
                'location_id' => $branchLocation->id,
            ]
        ]);

        // Create some additional random POS counters
        PosCounter::factory()->count(5)->create();
    }
};
