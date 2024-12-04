<?php

namespace App\Actions\Products;

use App\Models\ProductBundle;

class UpdateProductBundleAction
{
    public function execute(ProductBundle $bundle, array $data): ProductBundle
    {
        $bundle->update([
            'quantity' => $data['quantity'],
            'unit_id' => $data['unit_id'],
            'is_active' => $data['is_active'] ?? $bundle->is_active
        ]);

        return $bundle->fresh();
    }
} 