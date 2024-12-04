<?php

namespace Database\Factories;

use App\Models\UnitsOfMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UnitsOfMeasureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UnitsOfMeasure::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'code' => strtoupper($this->faker->unique()->lexify('???')),
            'name' => $this->faker->word,
            'category' => $this->faker->randomElement(['weight', 'length', 'volume', 'count']),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
