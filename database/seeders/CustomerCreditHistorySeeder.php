<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerCreditHistory;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerCreditHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user for credit history records
        $admin = User::where('email', 'admin@dearpos.com')->first();

        // Get all active customers
        $customers = Customer::where('status', 'active')->get();

        // Create credit history for each customer
        foreach ($customers as $customer) {
            // Create 3-7 credit history records per customer
            $count = fake()->numberBetween(3, 7);

            for ($i = 0; $i < $count; $i++) {
                $type = fake()->randomElement(['increase', 'decrease', 'adjustment']);
                $amount = fake()->randomFloat(4, 100, 5000);

                CustomerCreditHistory::factory()
                    ->create([
                        'customer_id' => $customer->id,
                        'transaction_type' => $type,
                        'amount' => $amount,
                        'created_by' => $admin->id,
                    ]);

                // Update customer's current balance
                if ($type === 'increase') {
                    $customer->current_balance += $amount;
                } elseif ($type === 'decrease') {
                    $customer->current_balance -= $amount;
                } else { // adjustment
                    $customer->current_balance = fake()->randomFloat(4, 0, 10000);
                }
            }

            $customer->save();
        }
    }
}
