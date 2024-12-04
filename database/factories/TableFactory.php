<?php

namespace Database\Factories;

use App\Models\Table;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Table::class;

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
            'branch_id' => $this->faker->optional()->uuid,
            'section_id' => $this->faker->optional()->uuid,
            'capacity' => $this->faker->numberBetween(1, 20),
            'table_type' => $this->faker->randomElement(['standard', 'vip', 'outdoor', 'private room']),
            'status' => $this->faker->randomElement(['available', 'occupied', 'reserved', 'cleaning']),
            'description' => $this->faker->sentence,
            'is_active' => $this->faker->boolean,
            'qr_code_url' => $this->faker->url,
            'floor_number' => $this->faker->numberBetween(1, 10),
            'x_coordinate' => $this->faker->randomFloat(2, 0, 100),
            'y_coordinate' => $this->faker->randomFloat(2, 0, 100),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
