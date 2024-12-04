<?php

namespace App\Actions\Marketplace;

use App\Models\MarketplaceShipping;

class CreateMarketplaceShippingAction
{
    public function execute(array $data): MarketplaceShipping
    {
        return MarketplaceShipping::create([
            'marketplace_order_id' => $data['marketplace_order_id'],
            'shipping_provider' => $data['shipping_provider'],
            'shipping_service' => $data['shipping_service'],
            'tracking_number' => $data['tracking_number'],
            'shipping_cost' => $data['shipping_cost'],
            'insurance_cost' => $data['insurance_cost'] ?? 0,
            'estimated_delivery_date' => $data['estimated_delivery_date'] ?? null,
            'actual_delivery_date' => $data['actual_delivery_date'] ?? null,
            'shipping_status' => $data['shipping_status'] ?? 'pending',
            'notes' => $data['notes'] ?? null
        ]);
    }
} 