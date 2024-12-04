<?php

namespace App\Actions\Positions;

use App\Models\Position;

class CreatePositionAction
{
    public function execute(array $data): Position
    {
        return Position::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'department_id' => $data['department_id'],
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? true
        ]);
    }
} 