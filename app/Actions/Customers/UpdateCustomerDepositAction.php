<?php

namespace App\Actions\Customers;

use App\Models\CustomerDeposit;

class UpdateCustomerDepositAction
{
    public function execute(CustomerDeposit $deposit, float $amount, string $operation = 'use'): CustomerDeposit
    {
        if ($operation === 'use') {
            $deposit->increment('used_amount', $amount);
            $deposit->decrement('remaining_amount', $amount);
        } else {
            $deposit->decrement('used_amount', $amount);
            $deposit->increment('remaining_amount', $amount);
        }

        return $deposit->fresh();
    }
} 