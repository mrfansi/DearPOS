<?php

namespace Database\Factories;

use App\Models\ShiftRotation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShiftRotationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShiftRotation::class;

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
            'department_id' => $this->faker->optional()->uuid,
            'rotation_type' => $this->faker->randomElement(['fixed', 'rotating', 'split']),
            'cycle_days' => $this->faker->numberBetween(1, 30),
            'start_date' => $this->faker->date(),
            'is_active' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
