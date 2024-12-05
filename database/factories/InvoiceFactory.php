<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\PosCounter;
use App\Models\SalesTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $subtotal = fake()->randomFloat(4, 100, 10000);
        $taxRate = fake()->randomFloat(2, 0, 15);
        $taxAmount = $subtotal * ($taxRate / 100);
        $discountAmount = fake()->randomFloat(4, 0, $subtotal * 0.2);
        $additionalCharges = fake()->randomFloat(4, 0, 100);
        $totalAmount = $subtotal + $taxAmount - $discountAmount + $additionalCharges;

        return [
            'invoice_number' => 'INV-' . fake()->unique()->numerify('######'),
            'sales_transaction_id' => fake()->boolean(50) ? SalesTransaction::factory() : null,
            'customer_id' => fake()->boolean(70) ? Customer::factory() : null,
            'branch_id' => Branch::factory(),
            'pos_counter_id' => PosCounter::factory(),
            'invoice_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'due_date' => fake()->dateTimeBetween('now', '+1 month'),
            'status' => fake()->randomElement(['draft', 'issued', 'sent', 'paid', 'partially_paid', 'overdue', 'cancelled']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'partially_paid', 'overdue']),
            'total_amount' => $totalAmount,
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'additional_charges' => $additionalCharges,
            'is_taxable' => fake()->boolean(70),
            'tax_rate' => $taxRate,
            'notes' => fake()->optional()->paragraph(),
            'created_by' => User::factory(),
            'printed_at' => fake()->boolean(30) ? fake()->dateTimeBetween('-1 month', 'now') : null,
            'sent_at' => fake()->boolean(40) ? fake()->dateTimeBetween('-1 month', 'now') : null,
        ];
    }

    public function draft(): static
    {
        return $this->state([
            'status' => 'draft',
            'payment_status' => 'pending',
        ]);
    }

    public function issued(): static
    {
        return $this->state([
            'status' => 'issued',
            'payment_status' => 'pending',
        ]);
    }

    public function paid(): static
    {
        return $this->state([
            'status' => 'paid',
            'payment_status' => 'paid',
        ]);
    }

    public function overdue(): static
    {
        return $this->state([
            'status' => 'overdue',
            'payment_status' => 'overdue',
            'due_date' => fake()->dateTimeBetween('-1 month', '-1 day'),
        ]);
    }
}
