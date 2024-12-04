<?php

namespace App\Actions\Marketplace;

use App\Models\MarketplaceOrder;
use Illuminate\Support\Str;

class SyncMarketplaceOrderAction
{
    public function execute(array $data): MarketplaceOrder
    {
        return MarketplaceOrder::create([
            'id' => Str::uuid(),
            'order_number' => $data['order_number'],
            'marketplace_id' => $data['marketplace_id'],
            'customer_id' => $data['customer_id'] ?? null,
            'branch_id' => $data['branch_id'],
            'sales_transaction_id' => $data['sales_transaction_id'] ?? null,
            'order_date' => $data['order_date'],
            'status' => $data['status'] ?? 'pending',
            'payment_status' => $data['payment_status'] ?? 'unpaid',
            'total_amount' => $data['total_amount'],
            'subtotal' => $data['subtotal'],
            'shipping_amount' => $data['shipping_amount'] ?? 0,
            'tax_amount' => $data['tax_amount'] ?? 0,
            'discount_amount' => $data['discount_amount'] ?? 0,
            'marketplace_commission' => $data['marketplace_commission'] ?? 0,
            'shipping_method' => $data['shipping_method'] ?? null,
            'tracking_number' => $data['tracking_number'] ?? null,
            'shipping_address_id' => $data['shipping_address_id'],
            'billing_address_id' => $data['billing_address_id'],
            'notes' => $data['notes'] ?? null,
            'external_order_id' => $data['external_order_id'],
            'fulfillment_status' => $data['fulfillment_status'] ?? 'not_fulfilled',
            'created_by' => $data['created_by']
        ]);
    }
} 