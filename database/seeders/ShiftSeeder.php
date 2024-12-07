<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        $shifts = [
            [
                'name' => 'Morning Shift',
                'start_time' => '06:00',
                'end_time' => '14:00',
                'duration_minutes' => 480,
                'description' => 'Standard morning work shift',
                'is_night_shift' => false,
                'is_active' => true
            ],
            [
                'name' => 'Afternoon Shift',
                'start_time' => '14:00',
                'end_time' => '22:00',
                'duration_minutes' => 480,
                'description' => 'Standard afternoon work shift',
                'is_night_shift' => false,
                'is_active' => true
            ],
            [
                'name' => 'Night Shift',
                'start_time' => '22:00',
                'end_time' => '06:00',
                'duration_minutes' => 480,
                'description' => 'Night-time work shift',
                'is_night_shift' => true,
                'is_active' => true
            ],
            [
                'name' => 'Split Shift',
                'start_time' => '06:00',
                'end_time' => '10:00',
                'duration_minutes' => 240,
                'description' => 'First part of split shift',
                'is_night_shift' => false,
                'is_active' => true
            ],
            [
                'name' => 'Split Shift (Second Part)',
                'start_time' => '16:00',
                'end_time' => '20:00',
                'duration_minutes' => 240,
                'description' => 'Second part of split shift',
                'is_night_shift' => false,
                'is_active' => true
            ],
            [
                'name' => 'Weekend Shift',
                'start_time' => '08:00',
                'end_time' => '16:00',
                'duration_minutes' => 480,
                'description' => 'Weekend work shift',
                'is_night_shift' => false,
                'is_active' => true
            ]
        ];

        foreach ($shifts as $shiftData) {
            Shift::create($shiftData);
        }

        // Add some additional random shifts
        Shift::factory()->count(3)->create();
    }
}
