<?php

namespace App\Actions\Marketplace;

use App\Models\MarketplaceProduct;

class UpdateMarketplaceProductStatusAction
{
    public function execute(MarketplaceProduct $product, bool $isActive, ?array $additionalData = []): MarketplaceProduct
    {
        $updateData = ['is_active' => $isActive];

        if (isset($additionalData['price'])) {
            $updateData['price'] = $additionalData['price'];
        }

        if (isset($additionalData['stock'])) {
            $updateData['stock'] = $additionalData['stock'];
        }

        if (isset($additionalData['sync_status'])) {
            $updateData['sync_status'] = $additionalData['sync_status'];
            $updateData['sync_message'] = $additionalData['sync_message'] ?? null;
            $updateData['last_sync_at'] = now();
        }

        $product->update($updateData);

        return $product->fresh();
    }
} 