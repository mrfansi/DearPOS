<?php

namespace App\Actions\Customers;

use App\Models\CustomerDeposit;
use Illuminate\Support\Str;

class CreateCustomerDepositAction
{
    public function execute(array $data): CustomerDeposit
    {
        return CustomerDeposit::create([
            'id' => Str::uuid(),
            'customer_id' => $data['customer_id'],
            'amount' => $data['amount'],
            'used_amount' => 0,
            'remaining_amount' => $data['amount'],
            'deposit_date' => $data['deposit_date'] ?? now(),
            'expiry_date' => $data['expiry_date'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => 'active'
        ]);
    }
} 