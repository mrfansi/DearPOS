<?php

namespace App\Actions\Marketplace;

use App\Models\MarketplaceShipping;

class UpdateMarketplaceShippingStatusAction
{
    public function execute(MarketplaceShipping $shipping, string $status, ?array $additionalData = []): MarketplaceShipping
    {
        $updateData = ['shipping_status' => $status];

        if (isset($additionalData['tracking_number'])) {
            $updateData['tracking_number'] = $additionalData['tracking_number'];
        }

        if (isset($additionalData['actual_delivery_date'])) {
            $updateData['actual_delivery_date'] = $additionalData['actual_delivery_date'];
        }

        if (isset($additionalData['notes'])) {
            $updateData['notes'] = $additionalData['notes'];
        }

        $shipping->update($updateData);

        return $shipping->fresh();
    }
} 