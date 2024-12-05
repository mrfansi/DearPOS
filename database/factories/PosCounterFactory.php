<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\PosCounter;
use Illuminate\Database\Eloquent\Factories\Factory;

class PosCounterFactory extends Factory
{
    protected $model = PosCounter::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'code' => strtoupper(fake()->unique()->bothify('POS-####-??')),
            'location_id' => Location::factory(),
            'is_active' => true,
            'description' => fake()->optional()->sentence(),
            'terminal_number' => fake()->optional()->bothify('TERM-####'),
            'printer_name' => fake()->optional()->bothify('PRT-####'),
            'cash_drawer_name' => fake()->optional()->bothify('CDR-####'),
            'customer_display' => fake()->optional()->bothify('DSP-####'),
        ];
    }

    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    public function withFullConfig(): static
    {
        return $this->state([
            'terminal_number' => fake()->bothify('TERM-####'),
            'printer_name' => fake()->bothify('PRT-####'),
            'cash_drawer_name' => fake()->bothify('CDR-####'),
            'customer_display' => fake()->bothify('DSP-####'),
        ]);
    }
}
