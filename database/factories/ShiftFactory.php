<?php

namespace Database\Factories;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ShiftFactory extends Factory
{
    protected $model = Shift::class;

    public function definition(): array
    {
        $startTime = $this->generateShiftTime();
        $endTime = $this->calculateEndTime($startTime);
        $durationMinutes = Carbon::parse($startTime)->diffInMinutes($endTime);

        return [
            'name' => $this->generateShiftName(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration_minutes' => $durationMinutes,
            'description' => $this->faker->optional()->sentence,
            'is_night_shift' => $this->isNightShift($startTime),
            'is_active' => $this->faker->boolean(90)
        ];
    }

    public function morning()
    {
        return $this->state([
            'name' => 'Morning Shift',
            'start_time' => '06:00',
            'end_time' => '14:00',
            'duration_minutes' => 480,
            'is_night_shift' => false
        ]);
    }

    public function afternoon()
    {
        return $this->state([
            'name' => 'Afternoon Shift',
            'start_time' => '14:00',
            'end_time' => '22:00',
            'duration_minutes' => 480,
            'is_night_shift' => false
        ]);
    }

    public function night()
    {
        return $this->state([
            'name' => 'Night Shift',
            'start_time' => '22:00',
            'end_time' => '06:00',
            'duration_minutes' => 480,
            'is_night_shift' => true
        ]);
    }

    private function generateShiftName()
    {
        $shiftNames = [
            'Day Shift',
            'Morning Shift',
            'Afternoon Shift',
            'Night Shift',
            'Split Shift',
            'Rotating Shift'
        ];

        return $this->faker->randomElement($shiftNames);
    }

    private function generateShiftTime()
    {
        $hours = $this->faker->numberBetween(0, 23);
        $minutes = $this->faker->randomElement([0, 15, 30, 45]);
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    private function calculateEndTime($startTime)
    {
        $start = Carbon::parse($startTime);
        $end = $start->copy()->addHours(8);
        return $end->format('H:i');
    }

    private function isNightShift($startTime)
    {
        $start = Carbon::parse($startTime);
        return $start->hour >= 22 || $start->hour < 6;
    }
}
