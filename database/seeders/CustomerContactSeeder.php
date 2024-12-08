<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerContact;
use Illuminate\Database\Seeder;

class CustomerContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        CustomerContact::query()->delete();

        // Get existing customers
        $customers = Customer::all();

        // Create contacts for each customer
        $customers->each(function (Customer $customer) {
            // Create a primary contact
            CustomerContact::factory()->create([
                'customer_id' => $customer->id,
                'is_primary' => true,
            ]);

            // Optionally create an additional contact
            if (rand(0, 1)) {
                CustomerContact::factory()->create([
                    'customer_id' => $customer->id,
                    'is_primary' => false,
                ]);
            }
        });
    }
}
