<?php

namespace App\Actions\Discounts;

use App\Models\Discount;
use Illuminate\Support\Str;

class CreateDiscountAction
{
    public function execute(array $data): Discount
    {
        return Discount::create([
            'id' => Str::uuid(),
            'name' => $data['name'],
            'code' => $data['code'],
            'description' => $data['description'] ?? null,
            'type' => $data['type'],
            'value' => $data['value'],
            'minimum_purchase_amount' => $data['minimum_purchase_amount'] ?? 0,
            'maximum_discount_amount' => $data['maximum_discount_amount'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'is_active' => $data['is_active'] ?? true,
            'applies_to' => $data['applies_to'] ?? 'all_products'
        ]);
    }
} 