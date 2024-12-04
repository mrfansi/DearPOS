<?php

namespace App\Actions\Marketplace;

use App\Models\MarketplaceOrder;

class UpdateOrderStatusAction
{
    public function execute(MarketplaceOrder $order, string $status, ?string $notes = null): MarketplaceOrder
    {
        $order->update([
            'status' => $status,
            'notes' => $notes ?? $order->notes,
            'fulfillment_status' => $status === 'delivered' ? 'fully_fulfilled' : $order->fulfillment_status
        ]);

        return $order->fresh();
    }
} 