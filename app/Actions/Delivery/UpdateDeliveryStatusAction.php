<?php

namespace App\Actions\Delivery;

use App\Models\DeliveryOrder;

class UpdateDeliveryStatusAction
{
    public function execute(DeliveryOrder $delivery, string $status, ?array $additionalData = []): DeliveryOrder
    {
        $updateData = ['status' => $status];
        
        if (isset($additionalData['actual_time'])) {
            $updateData['actual_time'] = $additionalData['actual_time'];
        }
        
        if (isset($additionalData['notes'])) {
            $updateData['notes'] = $additionalData['notes'];
        }

        $delivery->update($updateData);

        return $delivery->fresh();
    }
} 