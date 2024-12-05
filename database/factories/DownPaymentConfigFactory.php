<?php

namespace Database\Factories;

use App\Models\DownPaymentConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

class DownPaymentConfigFactory extends Factory
{
    protected $model = DownPaymentConfig::class;

    public function definition(): array
    {
        $minimumAmount = fake()->randomFloat(4, 10, 500);
        $maximumAmount = fake()->randomFloat(4, $minimumAmount, 5000);
        $percentage = fake()->randomFloat(2, 5, 50);

        return [
            'minimum_amount' => $minimumAmount,
            'maximum_amount' => $maximumAmount,
            'percentage' => $percentage,
            'is_active' => fake()->boolean(80),
        ];
    }

    public function active(): static
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    public function withLowPercentage(): static
    {
        return $this->state([
            'percentage' => fake()->randomFloat(2, 1, 10),
        ]);
    }

    public function withHighPercentage(): static
    {
        return $this->state([
            'percentage' => fake()->randomFloat(2, 50, 100),
        ]);
    }
}
