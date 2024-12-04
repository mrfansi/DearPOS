<?php

namespace App\Actions\Marketplace;

use App\Models\MarketplaceOrder;

class CreateMarketplaceOrderAction
{
    public function execute(array $data): MarketplaceOrder
    {
        return MarketplaceOrder::create([
            'marketplace_id' => $data['marketplace_id'],
            'external_order_id' => $data['external_order_id'],
            'order_number' => $data['order_number'],
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'] ?? null,
            'customer_email' => $data['customer_email'] ?? null,
            'shipping_address' => $data['shipping_address'],
            'total_amount' => $data['total_amount'],
            'shipping_fee' => $data['shipping_fee'] ?? 0,
            'tax_amount' => $data['tax_amount'] ?? 0,
            'discount_amount' => $data['discount_amount'] ?? 0,
            'status' => $data['status'] ?? 'pending',
            'payment_status' => $data['payment_status'] ?? 'unpaid',
            'fulfillment_status' => $data['fulfillment_status'] ?? 'unfulfilled',
            'notes' => $data['notes'] ?? null
        ]);
    }
} 