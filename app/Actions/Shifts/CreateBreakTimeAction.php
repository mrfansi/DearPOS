<?php

namespace App\Actions\Shifts;

use App\Models\BreakTime;
use Illuminate\Support\Str;

class CreateBreakTimeAction
{
    public function execute(array $data): BreakTime
    {
        return BreakTime::create([
            'id' => Str::uuid(),
            'shift_id' => $data['shift_id'],
            'break_type' => $data['break_type'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'duration_minutes' => $data['duration_minutes'],
            'is_paid' => $data['is_paid'] ?? false,
            'is_mandatory' => $data['is_mandatory'] ?? true
        ]);
    }
} 