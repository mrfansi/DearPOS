<?php

namespace App\Actions\Kitchen;

use App\Models\KitchenOrder;

class UpdateKitchenOrderStatusAction
{
    public function execute(KitchenOrder $order, string $status, ?string $notes = null): KitchenOrder
    {
        $order->update([
            'status' => $status,
            'notes' => $notes ?? $order->notes
        ]);

        return $order->fresh();
    }
} 