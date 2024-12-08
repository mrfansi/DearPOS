<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeAddress;
use Faker\Factory;
use Illuminate\Database\Seeder;

class EmployeeAddressSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Get all employees
        $employees = Employee::all();

        $addressTypes = ['home', 'mailing', 'temporary'];

        foreach ($employees as $employee) {
            // Create primary address
            EmployeeAddress::factory()->create([
                'employee_id' => $employee->id,
                'address_type' => 'home',
                'is_current' => true,
            ]);

            // Optionally create a secondary address for some employees
            if ($faker->boolean(30)) {
                EmployeeAddress::factory()->create([
                    'employee_id' => $employee->id,
                    'address_type' => $faker->randomElement(['mailing', 'temporary']),
                    'is_current' => false,
                ]);
            }
        }
    }
}
