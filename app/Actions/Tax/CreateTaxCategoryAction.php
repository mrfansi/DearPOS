<?php

namespace App\Actions\Tax;

use App\Models\TaxCategory;

class CreateTaxCategoryAction
{
    public function execute(array $data): TaxCategory
    {
        return TaxCategory::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? true
        ]);
    }
} 