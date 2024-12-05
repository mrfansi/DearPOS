<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $statuses = ['present', 'absent', 'late', 'early_leave'];
        $date = fake()->date();
        
        // Randomly decide if this is a full attendance record or not
        $hasClockIn = fake()->boolean(80);
        $hasClockOut = $hasClockIn ? fake()->boolean(70) : false;

        $clockIn = $hasClockIn 
            ? Carbon::parse($date)->setTime(
                fake()->numberBetween(7, 9), 
                fake()->numberBetween(0, 59)
            )
            : null;

        $clockOut = $hasClockOut && $clockIn
            ? $clockIn->copy()->addHours(fake()->numberBetween(6, 9))
            : null;

        return [
            'employee_id' => Employee::factory(),
            'date' => $date,
            'clock_in' => $clockIn ? $clockIn->format('H:i:s') : null,
            'clock_out' => $clockOut ? $clockOut->format('H:i:s') : null,
            'status' => $hasClockIn 
                ? (
                    $clockIn->hour > 9 ? 'late' : 
                    ($clockOut && $clockOut->hour < 16 ? 'early_leave' : 'present')
                ) 
                : 'absent',
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function present(): static
    {
        return $this->state(function () {
            $date = fake()->date();
            $clockIn = Carbon::parse($date)->setTime(8, 0);
            $clockOut = $clockIn->copy()->addHours(8);

            return [
                'clock_in' => $clockIn->format('H:i:s'),
                'clock_out' => $clockOut->format('H:i:s'),
                'status' => 'present',
            ];
        });
    }

    public function absent(): static
    {
        return $this->state([
            'clock_in' => null,
            'clock_out' => null,
            'status' => 'absent',
        ]);
    }

    public function late(): static
    {
        return $this->state(function () {
            $date = fake()->date();
            $clockIn = Carbon::parse($date)->setTime(10, 0);
            $clockOut = $clockIn->copy()->addHours(8);

            return [
                'clock_in' => $clockIn->format('H:i:s'),
                'clock_out' => $clockOut->format('H:i:s'),
                'status' => 'late',
            ];
        });
    }

    public function earlyLeave(): static
    {
        return $this->state(function () {
            $date = fake()->date();
            $clockIn = Carbon::parse($date)->setTime(8, 0);
            $clockOut = $clockIn->copy()->addHours(4);

            return [
                'clock_in' => $clockIn->format('H:i:s'),
                'clock_out' => $clockOut->format('H:i:s'),
                'status' => 'early_leave',
            ];
        });
    }
}
