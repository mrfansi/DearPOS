<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeShift;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EmployeeShiftFactory extends Factory
{
    protected $model = EmployeeShift::class;

    public function definition(): array
    {
        $employee = Employee::factory()->create();
        $shift = Shift::factory()->create();
        $shiftDate = $this->faker->dateTimeBetween('-3 months', '+3 months');
        $status = $this->faker->randomElement(['scheduled', 'worked', 'absent', 'late', 'early_leave']);

        return [
            'employee_id' => $employee->id,
            'shift_id' => $shift->id,
            'shift_date' => $shiftDate,
            'status' => $status,
            'actual_start_time' => $this->generateActualTime($shift, $status, 'start'),
            'actual_end_time' => $this->generateActualTime($shift, $status, 'end'),
            'notes' => $this->faker->optional()->sentence
        ];
    }

    public function withEmployee(Employee $employee)
    {
        return $this->state([
            'employee_id' => $employee->id
        ]);
    }

    public function withShift(Shift $shift)
    {
        return $this->state([
            'shift_id' => $shift->id
        ]);
    }

    public function worked()
    {
        return $this->state([
            'status' => 'worked'
        ]);
    }

    public function absent()
    {
        return $this->state([
            'status' => 'absent',
            'actual_start_time' => null,
            'actual_end_time' => null
        ]);
    }

    public function late()
    {
        return $this->state([
            'status' => 'late'
        ]);
    }

    private function generateActualTime(Shift $shift, $status, $timeType)
    {
        if ($status === 'absent') {
            return null;
        }

        $shiftTime = Carbon::parse($timeType === 'start' ? $shift->start_time : $shift->end_time);

        return match($status) {
            'late' => $timeType === 'start' 
                ? $shiftTime->addMinutes($this->faker->numberBetween(5, 60))->format('H:i') 
                : $shiftTime->format('H:i'),
            'early_leave' => $timeType === 'end'
                ? $shiftTime->subMinutes($this->faker->numberBetween(5, 60))->format('H:i')
                : $shiftTime->format('H:i'),
            default => $shiftTime->format('H:i')
        };
    }
}
