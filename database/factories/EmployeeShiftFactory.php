<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeShift;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeShiftFactory extends Factory
{
    protected $model = EmployeeShift::class;

    public function definition(): array
    {
        $employee = Employee::factory()->create();
        $shift = Shift::factory()->create();
        $date = $this->faker->dateTimeBetween('-3 months', '+3 months');
        $status = $this->faker->randomElement(['scheduled', 'in_progress', 'completed', 'absent', 'cancelled']);

        return [
            'employee_id' => $employee->id,
            'shift_id' => $shift->id,
            'date' => $date,
            'status' => $status,
            'actual_start' => $this->generateActualTime($shift, $status, 'start'),
            'actual_end' => $this->generateActualTime($shift, $status, 'end'),
            'notes' => $this->faker->optional()->sentence,
        ];
    }

    private function generateActualTime($shift, $status, $type): ?string
    {
        if ($status === 'scheduled' || $status === 'cancelled' || $status === 'absent') {
            return null;
        }

        $date = Carbon::now();
        $baseTime = $type === 'start' ? $shift->start_time : $shift->end_time;
        $variance = $this->faker->numberBetween(-30, 30); // minutes of variance

        return $date->setTimeFromTimeString($baseTime)->addMinutes($variance);
    }

    public function withEmployee(Employee $employee)
    {
        return $this->state([
            'employee_id' => $employee->id,
        ]);
    }

    public function withShift(Shift $shift)
    {
        return $this->state([
            'shift_id' => $shift->id,
        ]);
    }

    public function scheduled()
    {
        return $this->state([
            'status' => 'scheduled',
            'actual_start' => null,
            'actual_end' => null,
        ]);
    }

    public function inProgress()
    {
        return $this->state([
            'status' => 'in_progress',
            'actual_end' => null,
        ]);
    }

    public function completed()
    {
        return $this->state([
            'status' => 'completed',
        ]);
    }

    public function absent()
    {
        return $this->state([
            'status' => 'absent',
            'actual_start' => null,
            'actual_end' => null,
        ]);
    }

    public function cancelled()
    {
        return $this->state([
            'status' => 'cancelled',
            'actual_start' => null,
            'actual_end' => null,
        ]);
    }
}
