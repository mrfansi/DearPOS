<?php

namespace App\Actions\Marketplace;

use App\Models\MarketplaceOrderItem;

class CreateMarketplaceOrderItemAction
{
    public function execute(array $data): MarketplaceOrderItem
    {
        return MarketplaceOrderItem::create([
            'marketplace_order_id' => $data['marketplace_order_id'],
            'product_id' => $data['product_id'],
            'product_variant_id' => $data['product_variant_id'] ?? null,
            'quantity' => $data['quantity'],
            'unit_id' => $data['unit_id'],
            'unit_price' => $data['unit_price'],
            'total_price' => $data['total_price'],
            'discount_amount' => $data['discount_amount'] ?? 0,
            'tax_amount' => $data['tax_amount'] ?? 0,
            'fulfillment_status' => $data['fulfillment_status'] ?? 'not_fulfilled',
            'external_item_id' => $data['external_item_id'] ?? null,
            'notes' => $data['notes'] ?? null
        ]);
    }
} 