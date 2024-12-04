<?php

namespace App\Actions\Products;

use App\Models\ProductPrice;

class UpdateProductPriceAction
{
    public function execute(ProductPrice $price, array $data): ProductPrice
    {
        $price->update([
            'price' => $data['price'],
            'min_quantity' => $data['min_quantity'] ?? 1,
            'start_date' => $data['start_date'] ?? now(),
            'end_date' => $data['end_date'] ?? null
        ]);

        return $price->fresh();
    }
} 