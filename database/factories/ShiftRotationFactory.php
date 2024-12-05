<?php

namespace Database\Factories;

use App\Models\ShiftRotation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftRotationFactory extends Factory
{
    protected $model = ShiftRotation::class;

    public function definition(): array
    {
        $startTime = Carbon::parse(fake()->time());
        $endTime = $startTime->copy()->addHours(8);

        // Optional break time
        $hasBreak = fake()->boolean(70);
        $breakStart = $hasBreak 
            ? $startTime->copy()->addHours(3)->format('H:i:s')
            : null;
        $breakEnd = $hasBreak 
            ? $startTime->copy()->addHours(4)->format('H:i:s')
            : null;

        return [
            'name' => fake()->randomElement([
                'Morning Shift', 
                'Day Shift', 
                'Evening Shift', 
                'Night Shift'
            ]),
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'break_start' => $breakStart,
            'break_end' => $breakEnd,
        ];
    }

    public function morning(): static
    {
        return $this->state([
            'name' => 'Morning Shift',
            'start_time' => '06:00:00',
            'end_time' => '14:00:00',
            'break_start' => '10:00:00',
            'break_end' => '11:00:00',
        ]);
    }

    public function day(): static
    {
        return $this->state([
            'name' => 'Day Shift',
            'start_time' => '08:00:00',
            'end_time' => '16:00:00',
            'break_start' => '12:00:00',
            'break_end' => '13:00:00',
        ]);
    }

    public function evening(): static
    {
        return $this->state([
            'name' => 'Evening Shift',
            'start_time' => '14:00:00',
            'end_time' => '22:00:00',
            'break_start' => '18:00:00',
            'break_end' => '19:00:00',
        ]);
    }

    public function night(): static
    {
        return $this->state([
            'name' => 'Night Shift',
            'start_time' => '22:00:00',
            'end_time' => '06:00:00',
            'break_start' => '02:00:00',
            'break_end' => '03:00:00',
        ]);
    }

    public function withoutBreak(): static
    {
        return $this->state([
            'break_start' => null,
            'break_end' => null,
        ]);
    }
}
