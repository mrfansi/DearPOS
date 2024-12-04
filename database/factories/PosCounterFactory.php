<?php

namespace Database\Factories;

use App\Models\PosCounter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PosCounterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PosCounter::class;

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
            'code' => strtoupper($this->faker->unique()->lexify('POS??')),
            'location_id' => $this->faker->optional()->uuid,
            'is_active' => $this->faker->boolean,
            'description' => $this->faker->sentence,
            'terminal_number' => $this->faker->numberBetween(1, 10),
            'printer_name' => $this->faker->word,
            'cash_drawer_name' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
