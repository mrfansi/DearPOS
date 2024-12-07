<?php

namespace Database\Factories;

use App\Models\ProductPriceList;
use App\Models\ProductPriceListItem;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPriceListItem>
 */
class ProductPriceListItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductPriceListItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price_list_id' => ProductPriceList::factory(),
            'variant_id' => ProductVariant::factory(),
            'price' => fake()->randomFloat(4, 10, 1000),
            'min_quantity' => fake()->randomElement([1, 5, 10, 20, 50, 100]),
        ];
    }

    /**
     * Set a specific minimum quantity.
     */
    public function minQuantity(int $quantity): static
    {
        return $this->state(fn (array $attributes) => [
            'min_quantity' => $quantity,
        ]);
    }
}
