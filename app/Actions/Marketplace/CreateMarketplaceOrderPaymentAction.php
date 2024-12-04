<?php

namespace App\Actions\Marketplace;

use App\Models\MarketplaceOrderPayment;

class CreateMarketplaceOrderPaymentAction
{
    public function execute(array $data): MarketplaceOrderPayment
    {
        return MarketplaceOrderPayment::create([
            'marketplace_order_id' => $data['marketplace_order_id'],
            'payment_method_id' => $data['payment_method_id'],
            'amount' => $data['amount'],
            'payment_date' => $data['payment_date'] ?? now(),
            'reference_number' => $data['reference_number'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'payment_type' => $data['payment_type'] ?? 'customer_payment',
            'external_payment_id' => $data['external_payment_id'] ?? null,
            'notes' => $data['notes'] ?? null
        ]);
    }
} 