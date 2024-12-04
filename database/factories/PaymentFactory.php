<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'sales_transaction_id' => $this->faker->optional()->uuid,
            'payment_method_id' => $this->faker->optional()->uuid,
            'amount' => $this->faker->randomFloat(4, 0, 10000),
            'currency_id' => $this->faker->optional()->uuid,
            'exchange_rate' => $this->faker->randomFloat(4, 0.5, 2),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'payment_date' => $this->faker->dateTime(),
            'reference_number' => $this->faker->unique()->numerify('REF#####'),
            'notes' => $this->faker->sentence,
            'is_partial' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
