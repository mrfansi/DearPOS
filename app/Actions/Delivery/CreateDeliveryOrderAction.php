<?php

namespace App\Actions\Delivery;

use App\Models\DeliveryOrder;

class CreateDeliveryOrderAction
{
    public function execute(array $data): DeliveryOrder
    {
        return DeliveryOrder::create([
            'order_id' => $data['order_id'],
            'driver_id' => $data['driver_id'] ?? null,
            'delivery_address' => $data['delivery_address'],
            'delivery_fee' => $data['delivery_fee'],
            'estimated_time' => $data['estimated_time'] ?? null,
            'actual_time' => $data['actual_time'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'notes' => $data['notes'] ?? null
        ]);
    }
} 