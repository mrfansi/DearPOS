<?php

namespace Database\Factories;

use App\Models\StorageLocation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StorageLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StorageLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'warehouse_id' => $this->faker->optional()->uuid,
            'name' => $this->faker->word,
            'code' => strtoupper($this->faker->unique()->lexify('SL??')),
            'type' => $this->faker->randomElement(['shelf', 'rack', 'bin', 'pallet']),
            'description' => $this->faker->sentence,
            'is_active' => $this->faker->boolean,
            'capacity' => $this->faker->numberBetween(10, 1000),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
