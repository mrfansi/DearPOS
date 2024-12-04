<?php

namespace App\Actions\Payments;

use App\Models\PaymentGateway;

class CreatePaymentGatewayAction
{
    public function execute(array $data): PaymentGateway
    {
        return PaymentGateway::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'credentials' => $data['credentials'] ?? null,
            'is_active' => $data['is_active'] ?? true
        ]);
    }
} 