<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'invoice_number' => $this->faker->unique()->numerify('INV#####'),
            'sales_transaction_id' => $this->faker->optional()->uuid,
            'customer_id' => $this->faker->optional()->uuid,
            'branch_id' => $this->faker->optional()->uuid,
            'pos_counter_id' => $this->faker->optional()->uuid,
            'invoice_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['draft', 'issued', 'paid', 'overdue', 'cancelled']),
            'payment_status' => $this->faker->randomElement(['unpaid', 'partial', 'paid']),
            'total_amount' => $this->faker->randomFloat(4, 0, 10000),
            'subtotal' => $this->faker->randomFloat(4, 0, 8000),
            'tax_amount' => $this->faker->randomFloat(4, 0, 2000),
            'discount_amount' => $this->faker->randomFloat(4, 0, 1000),
            'additional_charges' => $this->faker->randomFloat(4, 0, 500),
            'notes' => $this->faker->sentence,
            'is_taxable' => $this->faker->boolean,
            'tax_rate' => $this->faker->randomFloat(4, 0, 0.2),
            'created_by' => $this->faker->uuid,
            'printed_at' => $this->faker->optional()->dateTime(),
            'sent_at' => $this->faker->optional()->dateTime(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
