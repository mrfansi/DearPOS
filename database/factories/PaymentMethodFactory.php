<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->word,
            'code' => strtoupper($this->faker->unique()->lexify('PAY??')),
            'type' => $this->faker->randomElement(['cash', 'card', 'transfer']),
            'is_active' => $this->faker->boolean,
            'description' => $this->faker->sentence,
            'requires_reference' => $this->faker->boolean,
            'supports_installments' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
