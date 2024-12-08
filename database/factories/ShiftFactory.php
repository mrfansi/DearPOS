<?php

namespace Database\Factories;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShiftFactory extends Factory
{
    protected $model = Shift::class;

    public function definition(): array
    {
        $startTime = $this->generateShiftTime();
        $endTime = $this->calculateEndTime($startTime);

        return [
            'name' => $this->generateShiftName(),
            'code' => $this->generateShiftCode(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'break_duration' => $this->faker->numberBetween(30, 90),
            'description' => $this->faker->optional()->sentence,
            'is_overnight' => $this->isOvernight($startTime, $endTime),
            'is_active' => $this->faker->boolean(90),
        ];
    }

    public function morning()
    {
        return $this->state([
            'name' => 'Morning Shift',
            'code' => 'SH-MORN',
            'start_time' => '07:00',
            'end_time' => '15:00',
            'break_duration' => 60,
            'is_overnight' => false,
        ]);
    }

    public function afternoon()
    {
        return $this->state([
            'name' => 'Afternoon Shift',
            'code' => 'SH-NOON',
            'start_time' => '14:00',
            'end_time' => '22:00',
            'break_duration' => 60,
            'is_overnight' => false,
        ]);
    }

    public function night()
    {
        return $this->state([
            'name' => 'Night Shift',
            'code' => 'SH-NITE',
            'start_time' => '22:00',
            'end_time' => '06:00',
            'break_duration' => 60,
            'is_overnight' => true,
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
            'Rotating Shift',
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

    private function generateShiftCode(): string
    {
        $prefix = 'SH';
        $suffix = strtoupper(substr(uniqid(), -8));

        return "{$prefix}-{$suffix}";
    }

    private function isOvernight($startTime, $endTime): bool
    {
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);

        return $start->gt($end);
    }
}
