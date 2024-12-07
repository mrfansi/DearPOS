<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{2}'),
            'name' => $this->faker->randomElement([
                'Cash', 'Credit Card', 'Debit Card', 
                'Bank Transfer', 'E-Wallet', 'PayPal'
            ]),
            'description' => $this->faker->optional()->sentence(),
            'is_cash' => $this->faker->boolean(30),
            'is_card' => $this->faker->boolean(40),
            'is_digital' => $this->faker->boolean(50),
            'is_active' => $this->faker->boolean(80)
        ];
    }

    public function inactive()
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false
        ]);
    }
};
