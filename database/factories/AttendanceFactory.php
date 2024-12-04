<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $attendanceDate = $this->faker->date();
        $checkIn = Carbon::parse($attendanceDate)->setTime(
            $this->faker->numberBetween(6, 9), 
            $this->faker->numberBetween(0, 59)
        );
        $checkOut = $checkIn->copy()->addHours($this->faker->numberBetween(6, 9));
        $workedHours = $checkOut->diffInHours($checkIn);

        return [
            'id' => $this->faker->uuid,
            'employee_id' => $this->faker->optional()->uuid,
            'shift_id' => $this->faker->optional()->uuid,
            'attendance_date' => $attendanceDate,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'status' => $this->faker->randomElement(['present', 'late', 'absent', 'early_leave']),
            'worked_hours' => $workedHours,
            'notes' => $this->faker->optional()->sentence,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
