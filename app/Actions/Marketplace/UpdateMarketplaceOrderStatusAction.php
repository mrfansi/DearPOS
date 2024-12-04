<?php

namespace App\Actions\Marketplace;

use App\Models\MarketplaceOrder;

class UpdateMarketplaceOrderStatusAction
{
    public function execute(MarketplaceOrder $order, string $status, ?array $additionalData = []): MarketplaceOrder
    {
        $updateData = ['status' => $status];

        if (isset($additionalData['payment_status'])) {
            $updateData['payment_status'] = $additionalData['payment_status'];
        }

        if (isset($additionalData['fulfillment_status'])) {
            $updateData['fulfillment_status'] = $additionalData['fulfillment_status'];
        }

        if (isset($additionalData['tracking_number'])) {
            $updateData['tracking_number'] = $additionalData['tracking_number'];
        }

        if (isset($additionalData['notes'])) {
            $updateData['notes'] = $additionalData['notes'];
        }

        $order->update($updateData);

        return $order->fresh();
    }
} 