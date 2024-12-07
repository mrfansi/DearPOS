<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\CustomerAddress;
use App\Models\CustomerContact;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all customer groups
        $groups = CustomerGroup::all();

        // Create customers for each group
        foreach ($groups as $group) {
            // Create 3-5 customers per group
            $count = fake()->numberBetween(3, 5);

            // Create customers
            $customers = Customer::factory()
                ->count($count)
                ->active()
                ->inGroup($group)
                ->create();

            // Add addresses and contacts for each customer
            foreach ($customers as $customer) {
                // Create 1-3 addresses
                $addressCount = fake()->numberBetween(1, 3);
                for ($i = 0; $i < $addressCount; $i++) {
                    CustomerAddress::factory()->create([
                        'customer_id' => $customer->id,
                        'is_default' => $i === 0,
                    ]);
                }

                // Create 1-2 contacts
                $contactCount = fake()->numberBetween(1, 2);
                for ($i = 0; $i < $contactCount; $i++) {
                    CustomerContact::factory()->create([
                        'customer_id' => $customer->id,
                        'is_primary' => $i === 0,
                    ]);
                }
            }
        }

        // Create some customers with different statuses
        Customer::factory()->count(2)->inactive()->create();
        Customer::factory()->count(1)->blocked()->create();
    }
}
