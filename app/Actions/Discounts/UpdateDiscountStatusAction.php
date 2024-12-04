<?php

namespace App\Actions\Discounts;

use App\Models\Discount;

class UpdateDiscountStatusAction
{
    public function execute(Discount $discount, bool $isActive): Discount
    {
        $discount->update([
            'is_active' => $isActive,
            'end_date' => !$isActive ? now() : $discount->end_date
        ]);

        return $discount->fresh();
    }
} 