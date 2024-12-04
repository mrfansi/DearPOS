<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Position::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'title' => $this->faker->jobTitle,
            'code' => strtoupper($this->faker->unique()->lexify('POS??')),
            'department_id' => $this->faker->optional()->uuid,
            'job_description' => $this->faker->sentence,
            'minimum_salary' => $this->faker->randomFloat(4, 10000, 30000),
            'maximum_salary' => $this->faker->randomFloat(4, 30000, 100000),
            'is_management_position' => $this->faker->boolean,
            'is_active' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
