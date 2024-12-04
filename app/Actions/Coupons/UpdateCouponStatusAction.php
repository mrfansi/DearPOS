<?php

namespace App\Actions\Coupons;

use App\Models\Coupon;

class UpdateCouponStatusAction
{
    public function execute(Coupon $coupon, bool $isActive): Coupon
    {
        $coupon->update([
            'is_active' => $isActive
        ]);

        return $coupon->fresh();
    }
} 