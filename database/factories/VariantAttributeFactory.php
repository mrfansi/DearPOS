<?php

namespace Database\Factories;

use App\Models\VariantAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VariantAttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VariantAttribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'variant_id' => $this->faker->optional()->uuid,
            'attribute_id' => $this->faker->optional()->uuid,
            'value' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
