<?php

namespace Database\Factories;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ShiftFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Shift::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startTime = $this->faker->time('H:i');
        $endTime = Carbon::createFromFormat('H:i', $startTime)->addHours(8)->format('H:i');
        $workingHours = 8;

        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->word,
            'code' => strtoupper($this->faker->unique()->lexify('SHIFT??')),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'working_hours' => $workingHours,
            'type' => $this->faker->randomElement(['morning', 'afternoon', 'night', 'split']),
            'is_active' => $this->faker->boolean,
            'description' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
