<?php

namespace App\Actions\Attendance;

use App\Models\Attendance;

class CreateAttendanceAction
{
    public function execute(array $data): Attendance
    {
        return Attendance::create([
            'employee_id' => $data['employee_id'],
            'date' => $data['date'] ?? now()->toDateString(),
            'clock_in' => $data['clock_in'] ?? now()->toTimeString(),
            'clock_out' => $data['clock_out'] ?? null,
            'status' => $data['status'] ?? 'present',
            'notes' => $data['notes'] ?? null
        ]);
    }
} 