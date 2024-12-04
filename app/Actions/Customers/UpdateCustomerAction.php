<?php

namespace App\Actions\Customers;

use App\Models\Customer;

class UpdateCustomerAction
{
    public function execute(Customer $customer, array $data): Customer
    {
        $customer->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'country' => $data['country'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'tax_number' => $data['tax_number'] ?? null,
            'customer_type' => $data['customer_type'] ?? 'regular',
            'loyalty_points' => $data['loyalty_points'] ?? $customer->loyalty_points,
            'is_active' => $data['is_active'] ?? true,
            'notes' => $data['notes'] ?? null
        ]);

        return $customer->fresh();
    }
} 