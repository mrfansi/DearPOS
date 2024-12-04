<?php

namespace App\Actions\Tax;

use App\Models\TaxRule;

class CreateTaxRuleAction
{
    public function execute(array $data): TaxRule
    {
        return TaxRule::create([
            'tax_rate_id' => $data['tax_rate_id'],
            'country' => $data['country'] ?? null,
            'state' => $data['state'] ?? null,
            'city' => $data['city'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'priority' => $data['priority'] ?? 0,
            'is_active' => $data['is_active'] ?? true
        ]);
    }
} 