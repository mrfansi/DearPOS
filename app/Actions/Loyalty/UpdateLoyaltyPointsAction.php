<?php

namespace App\Actions\Loyalty;

use App\Models\Customer;

class UpdateLoyaltyPointsAction
{
    public function execute(Customer $customer, int $points, string $operation = 'add'): Customer
    {
        if ($operation === 'add') {
            $customer->increment('loyalty_points', $points);
        } else {
            $customer->decrement('loyalty_points', $points);
        }

        return $customer->fresh();
    }
} 