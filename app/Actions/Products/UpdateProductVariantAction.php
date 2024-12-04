<?php

namespace App\Actions\Products;

use App\Models\ProductVariant;

class UpdateProductVariantAction
{
    public function execute(ProductVariant $variant, array $data): ProductVariant
    {
        $variant->update([
            'sku' => $data['sku'],
            'barcode' => $data['barcode'] ?? null,
            'is_active' => $data['is_active'] ?? $variant->is_active
        ]);

        return $variant->fresh();
    }
} 