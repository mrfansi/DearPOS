<?php

namespace App\Actions\Coupons;

use App\Models\Coupon;
use Illuminate\Support\Str;

class CreateCouponAction
{
    public function execute(array $data): Coupon
    {
        return Coupon::create([
            'id' => Str::uuid(),
            'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'type' => $data['type'],
            'value' => $data['value'],
            'minimum_purchase_amount' => $data['minimum_purchase_amount'] ?? 0,
            'maximum_coupon_amount' => $data['maximum_coupon_amount'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'usage_limit' => $data['usage_limit'] ?? null,
            'per_customer_limit' => $data['per_customer_limit'] ?? null,
            'is_active' => $data['is_active'] ?? true
        ]);
    }
} 