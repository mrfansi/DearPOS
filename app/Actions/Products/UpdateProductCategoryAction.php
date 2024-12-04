<?php

namespace App\Actions\Products;

use App\Models\ProductCategory;

class UpdateProductCategoryAction
{
    public function execute(ProductCategory $category, array $data): ProductCategory
    {
        $category->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'parent_id' => $data['parent_id'] ?? null,
            'is_active' => $data['is_active'] ?? $category->is_active
        ]);

        return $category->fresh();
    }
} 