<?php

namespace App\Actions\Addresses;

use App\Models\Address;
use Illuminate\Support\Str;

class CreateAddressAction
{
    public function execute(array $data): Address
    {
        return Address::create([
            'id' => Str::uuid(),
            'name' => $data['name'],
            'phone' => $data['phone'],
            'street_address' => $data['street_address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'postal_code' => $data['postal_code'],
            'country' => $data['country'],
            'customer_id' => $data['customer_id'],
            'is_primary' => $data['is_primary'] ?? false,
            'address_type' => $data['address_type']
        ]);
    }
} 