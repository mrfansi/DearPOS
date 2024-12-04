<?php

namespace App\Actions\Kitchen;

use App\Models\CookingTime;

class TrackCookingTimeAction
{
    public function execute(array $data): CookingTime
    {
        return CookingTime::create([
            'kitchen_order_id' => $data['kitchen_order_id'],
            'start_time' => $data['start_time'] ?? now(),
            'end_time' => $data['end_time'] ?? null,
            'duration' => $data['duration'] ?? null,
            'chef_id' => $data['chef_id'] ?? null,
            'notes' => $data['notes'] ?? null
        ]);
    }
} 