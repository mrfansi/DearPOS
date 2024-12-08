<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerAudit;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        CustomerAudit::query()->delete();

        // Get existing customers and users
        $customers = Customer::all();
        $users = User::all();

        // Create audit logs for customers
        $customers->each(function (Customer $customer) use ($users) {
            // Randomly select events to create audit logs
            $events = ['created', 'updated', 'status_changed', 'credit_changed'];

            foreach ($events as $event) {
                if (rand(0, 1)) {
                    CustomerAudit::factory()->create([
                        'auditable_type' => Customer::class,
                        'auditable_id' => $customer->id,
                        'event' => $event,
                        'user_id' => $users->random()->id,
                        'old_values' => $event === 'created' ? null : json_encode(['key' => 'value']),
                        'new_values' => json_encode(['key' => 'new_value']),
                    ]);
                }
            }
        });
    }
}
