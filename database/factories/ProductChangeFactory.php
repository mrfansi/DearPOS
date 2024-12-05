<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductChange;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductChangeFactory extends Factory
{
    protected $model = ProductChange::class;

    public function definition(): array
    {
        $changeTypes = ['price', 'attribute', 'inventory', 'location', 'image'];
        $fieldNames = [
            'price' => ['base_price', 'special_price', 'wholesale_price'],
            'attribute' => ['name', 'sku', 'description'],
            'inventory' => ['quantity', 'reserved_quantity'],
            'location' => ['warehouse', 'position', 'shelf'],
            'image' => ['primary_image', 'gallery_image'],
        ];
        
        $changeType = fake()->randomElement($changeTypes);
        $fieldName = fake()->randomElement($fieldNames[$changeType]);
        
        return [
            'product_id' => Product::factory(),
            'change_type' => $changeType,
            'field_name' => $fieldName,
            'old_value' => fake()->word(),
            'new_value' => fake()->word(),
            'changed_by' => User::factory(),
        ];
    }

    public function priceChange(): static
    {
        return $this->state(function (array $attributes) {
            $old = fake()->randomFloat(2, 10, 100);
            $new = fake()->randomFloat(2, 10, 100);
            
            return [
                'change_type' => 'price',
                'field_name' => 'base_price',
                'old_value' => $old,
                'new_value' => $new,
            ];
        });
    }

    public function inventoryChange(): static
    {
        return $this->state(function (array $attributes) {
            $old = fake()->numberBetween(0, 100);
            $new = fake()->numberBetween(0, 100);
            
            return [
                'change_type' => 'inventory',
                'field_name' => 'quantity',
                'old_value' => $old,
                'new_value' => $new,
            ];
        });
    }
}
