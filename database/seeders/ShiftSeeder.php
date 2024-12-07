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
                'code' => 'SH-MORN',
                'start_time' => '07:00',
                'end_time' => '15:00',
                'break_duration' => 60,
                'is_overnight' => false,
                'is_active' => true
            ],
            [
                'name' => 'Afternoon Shift',
                'code' => 'SH-NOON',
                'start_time' => '15:00',
                'end_time' => '23:00',
                'break_duration' => 60,
                'is_overnight' => false,
                'is_active' => true
            ],
            [
                'name' => 'Night Shift',
                'code' => 'SH-NITE',
                'start_time' => '23:00',
                'end_time' => '07:00',
                'break_duration' => 60,
                'is_overnight' => true,
                'is_active' => true
            ],
            [
                'name' => 'Split Shift',
                'code' => 'SH-SPLT',
                'start_time' => '06:00',
                'end_time' => '20:00',
                'break_duration' => 120,
                'is_overnight' => false,
                'is_active' => true
            ],
            [
                'name' => 'Weekend Shift',
                'code' => 'SH-WKND',
                'start_time' => '09:00',
                'end_time' => '17:00',
                'break_duration' => 60,
                'is_overnight' => false,
                'is_active' => true
            ]
        ];

        foreach ($shifts as $shift) {
            Shift::create($shift);
        }
    }
}
