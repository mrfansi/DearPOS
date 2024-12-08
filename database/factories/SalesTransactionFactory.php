<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Customer;
use App\Models\PosCounter;
use App\Models\SalesTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesTransaction>
 */
class SalesTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(4, 10, 1000);
        $taxRate = fake()->randomFloat(2, 0, 0.15);
        $discountRate = fake()->randomFloat(2, 0, 0.2);
        $taxAmount = $subtotal * $taxRate;
        $discountAmount = $subtotal * $discountRate;
        $totalAmount = $subtotal + $taxAmount - $discountAmount;

        // Get the default currency (USD or first available currency)
        $defaultCurrency = Currency::where('code', 'USD')->first() ?? Currency::first();

        return [
            'transaction_number' => 'SALE-'.Str::upper(Str::random(8)),
            'customer_id' => fake()->boolean(70) ? Customer::factory() : null,
            'pos_counter_id' => PosCounter::factory(),
            'currency_id' => $defaultCurrency->id,
            'transaction_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'payment_status' => fake()->randomElement([
                SalesTransaction::PAYMENT_STATUS_UNPAID,
                SalesTransaction::PAYMENT_STATUS_PARTIAL,
                SalesTransaction::PAYMENT_STATUS_PAID,
            ]),
            'status' => fake()->randomElement([
                SalesTransaction::STATUS_DRAFT,
                SalesTransaction::STATUS_COMPLETED,
                SalesTransaction::STATUS_VOIDED,
            ]),
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
            'created_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the transaction is completed and paid.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => SalesTransaction::PAYMENT_STATUS_PAID,
            'status' => SalesTransaction::STATUS_COMPLETED,
        ]);
    }

    /**
     * Indicate that the transaction is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => SalesTransaction::PAYMENT_STATUS_UNPAID,
            'status' => SalesTransaction::STATUS_DRAFT,
        ]);
    }

    /**
     * Indicate that the transaction is voided.
     */
    public function voided(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => SalesTransaction::PAYMENT_STATUS_UNPAID,
            'status' => SalesTransaction::STATUS_VOIDED,
        ]);
    }
}
