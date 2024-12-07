<?php

namespace Database\Seeders;

use App\Models\CustomerGroup;
use Illuminate\Database\Seeder;

class CustomerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default customer groups
        $groups = [
            [
                'name' => 'Regular',
                'description' => 'Regular customers with standard pricing',
                'discount_percentage' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Silver',
                'description' => 'Silver tier customers with 5% discount',
                'discount_percentage' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Gold',
                'description' => 'Gold tier customers with 10% discount',
                'discount_percentage' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Platinum',
                'description' => 'Platinum tier customers with 15% discount',
                'discount_percentage' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'Wholesale',
                'description' => 'Wholesale customers with 20% discount',
                'discount_percentage' => 20,
                'is_active' => true,
            ],
        ];

        foreach ($groups as $group) {
            CustomerGroup::create($group);
        }

        // Create some random groups for testing
        CustomerGroup::factory()->count(3)->create();
    }
}
