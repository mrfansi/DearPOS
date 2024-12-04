<?php

namespace App\Actions\Products;

use App\Models\Product;

class UpdateProductStatusAction
{
    public function execute(Product $product, bool $isActive): Product
    {
        $product->update([
            'is_active' => $isActive
        ]);

        return $product->fresh();
    }
} 