<?php

namespace App\Actions\Kitchen;

use App\Models\KitchenOrder;

class CreateKitchenOrderAction
{
    public function execute(array $data): KitchenOrder
    {
        return KitchenOrder::create([
            'order_id' => $data['order_id'],
            'station_id' => $data['station_id'],
            'priority' => $data['priority'] ?? 'normal',
            'status' => $data['status'] ?? 'pending',
            'preparation_time' => $data['preparation_time'] ?? null,
            'notes' => $data['notes'] ?? null
        ]);
    }
} 