<?php

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

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
            'code' => strtoupper($this->faker->unique()->lexify('DISC??')),
            'description' => $this->faker->sentence,
            'type' => $this->faker->randomElement(['percentage', 'fixed_amount', 'buy_x_get_y']),
            'value' => $this->faker->randomFloat(4, 0, 100),
            'minimum_purchase_amount' => $this->faker->randomFloat(4, 0, 1000),
            'maximum_discount_amount' => $this->faker->randomFloat(4, 0, 500),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'is_active' => $this->faker->boolean,
            'applies_to' => $this->faker->randomElement(['all_products', 'specific_products', 'specific_categories']),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
