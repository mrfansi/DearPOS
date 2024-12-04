<?php

namespace App\Actions\Delivery;

use App\Models\DeliveryOrder;

class AssignDriverAction
{
    public function execute(DeliveryOrder $delivery, int $driverId): DeliveryOrder
    {
        $delivery->update([
            'driver_id' => $driverId,
            'status' => 'assigned'
        ]);

        return $delivery->fresh();
    }
} 