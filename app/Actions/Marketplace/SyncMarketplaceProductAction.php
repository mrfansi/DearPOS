<?php

namespace App\Actions\Marketplace;

use App\Models\MarketplaceProduct;
use App\Models\Product;

class SyncMarketplaceProductAction
{
    public function execute(Product $product, array $data): MarketplaceProduct
    {
        return MarketplaceProduct::create([
            'marketplace_id' => $data['marketplace_id'],
            'product_id' => $product->id,
            'external_product_id' => $data['external_product_id'],
            'external_shop_id' => $data['external_shop_id'],
            'marketplace_category_id' => $data['marketplace_category_id'],
            'marketplace_url' => $data['marketplace_url'] ?? null,
            'price' => $data['price'],
            'stock' => $data['stock'],
            'is_active' => $data['is_active'] ?? true,
            'last_sync_at' => now(),
            'sync_status' => $data['sync_status'] ?? 'success',
            'sync_message' => $data['sync_message'] ?? null
        ]);
    }
} 