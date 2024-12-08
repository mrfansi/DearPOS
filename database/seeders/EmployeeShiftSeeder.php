<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeShift;
use App\Models\Shift;
use Faker\Factory;
use Illuminate\Database\Seeder;

class EmployeeShiftSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Get active employees and shifts
        $employees = Employee::where('status', 'active')->limit(10)->get();
        $shifts = Shift::all();

        $shiftData = [];

        // Create shifts for the next 7 days only
        foreach ($employees as $employee) {
            for ($i = 0; $i < 7; $i++) {
                $date = now()->addDays($i);

                // 70% chance of having a shift
                if ($faker->boolean(70)) {
                    $shift = $shifts->random();
                    $status = $faker->randomElement(['scheduled', 'in_progress']);

                    $shiftData[] = [
                        'id' => $faker->uuid(),
                        'employee_id' => $employee->id,
                        'shift_id' => $shift->id,
                        'date' => $date,
                        'actual_start' => null,
                        'actual_end' => null,
                        'status' => $status,
                        'notes' => $faker->optional(0.3)->sentence(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Bulk insert all shifts at once
        foreach (array_chunk($shiftData, 100) as $chunk) {
            EmployeeShift::insert($chunk);
        }
    }
}
