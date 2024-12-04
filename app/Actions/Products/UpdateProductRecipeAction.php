<?php

namespace App\Actions\Products;

use App\Models\ProductRecipe;

class UpdateProductRecipeAction
{
    public function execute(ProductRecipe $recipe, array $data): ProductRecipe
    {
        $recipe->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'output_quantity' => $data['output_quantity'],
            'output_unit_id' => $data['output_unit_id'],
            'instructions' => $data['instructions'] ?? null
        ]);

        return $recipe->fresh();
    }
} 