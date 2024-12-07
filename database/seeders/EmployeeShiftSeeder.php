<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeShift;
use App\Models\Shift;
use Illuminate\Database\Seeder;
use Faker\Factory;

class EmployeeShiftSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Get all employees and shifts
        $employees = Employee::all();
        $shifts = Shift::all();

        // For each employee
        foreach ($employees as $employee) {
            // Create shifts for the next 30 days
            for ($i = 0; $i < 30; $i++) {
                $date = now()->addDays($i);
                
                // 70% chance of having a shift on any given day
                if ($faker->boolean(70)) {
                    $shift = $shifts->random();
                    $status = $faker->randomElement(['scheduled', 'in_progress', 'completed', 'absent', 'cancelled']);

                    EmployeeShift::factory()->create([
                        'employee_id' => $employee->id,
                        'shift_id' => $shift->id,
                        'date' => $date,
                        'actual_start' => $status === 'completed' ? $date->copy()->setTimeFromTimeString($shift->start_time) : null,
                        'actual_end' => $status === 'completed' ? $date->copy()->setTimeFromTimeString($shift->end_time) : null,
                        'status' => $status,
                        'notes' => $faker->optional()->sentence()
                    ]);
                }
            }
        }
    }
}
