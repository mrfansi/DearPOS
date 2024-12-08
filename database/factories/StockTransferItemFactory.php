<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockTransfer;
use App\Models\StockTransferItem;
use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockTransferItemFactory extends Factory
{
    protected $model = StockTransferItem::class;

    public function definition(): array
    {
        $product = Product::factory()->create();
        $transfer = StockTransfer::factory()->create();
        $unit = UnitOfMeasure::factory()->create();
        $quantityRequested = $this->faker->randomFloat(4, 1, 100);

        return [
            'transfer_id' => $transfer->id,
            'product_id' => $product->id,
            'product_variant_id' => $this->faker->boolean(30) ? ProductVariant::factory()->create(['product_id' => $product->id])->id : null,
            'quantity_requested' => $quantityRequested,
            'quantity_sent' => $transfer->status === 'completed' ? $this->faker->randomFloat(4, 0, $quantityRequested) : null,
            'quantity_received' => $transfer->status === 'completed' ? $this->faker->randomFloat(4, 0, $quantityRequested) : null,
            'unit_id' => $unit->id,
            'lot_number' => $this->faker->optional()->bothify('LOT-####??'),
            'expiry_date' => $this->faker->optional()->dateTimeBetween('+1 month', '+2 years'),
            'notes' => $this->faker->optional()->sentence
        ];
    }

    public function forTransfer(StockTransfer $transfer)
    {
        return $this->state([
            'transfer_id' => $transfer->id
        ]);
    }

    public function withProduct(Product $product)
    {
        return $this->state([
            'product_id' => $product->id
        ]);
    }

    public function withVariant(ProductVariant $variant)
    {
        return $this->state([
            'product_id' => $variant->product_id,
            'product_variant_id' => $variant->id
        ]);
    }

    public function withUnit(UnitOfMeasure $unit)
    {
        return $this->state([
            'unit_id' => $unit->id
        ]);
    }
}
