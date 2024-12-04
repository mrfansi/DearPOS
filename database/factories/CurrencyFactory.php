<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'code' => $this->faker->unique()->currencyCode,
            'name' => $this->faker->unique()->country,
            'exchange_rate' => $this->faker->randomFloat(4, 0.5, 20),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
