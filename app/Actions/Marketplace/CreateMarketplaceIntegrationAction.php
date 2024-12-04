<?php

namespace App\Actions\Marketplace;

use App\Models\Marketplace;

class CreateMarketplaceIntegrationAction
{
    public function execute(array $data): Marketplace
    {
        return Marketplace::create([
            'name' => $data['name'],
            'platform_code' => $data['platform_code'],
            'commission_rate' => $data['commission_rate'],
            'api_key' => $data['api_key'],
            'api_secret' => $data['api_secret'],
            'webhook_url' => $data['webhook_url'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'sync_frequency' => $data['sync_frequency'] ?? 'daily',
            'integration_type' => $data['integration_type'] ?? 'direct',
            'support_email' => $data['support_email'] ?? null,
            'support_phone' => $data['support_phone'] ?? null
        ]);
    }
} 