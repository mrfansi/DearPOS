<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Database\Seeder;

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        CustomerAddress::query()->delete();

        // Get existing customers
        $customers = Customer::all();

        // Create addresses for each customer
        $customers->each(function (Customer $customer) {
            // Create a billing address
            CustomerAddress::factory()->create([
                'customer_id' => $customer->id,
                'address_type' => 'billing',
                'is_default' => true,
            ]);

            // Optionally create a shipping address
            if (rand(0, 1)) {
                CustomerAddress::factory()->create([
                    'customer_id' => $customer->id,
                    'address_type' => 'shipping',
                    'is_default' => false,
                ]);
            }
        });
    }
}
