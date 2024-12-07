<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierReturn;
use App\Models\SupplierReturnItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierReturnFactory extends Factory
{
    protected $model = SupplierReturn::class;

    public function definition(): array
    {
        $totalAmount = $this->faker->randomFloat(4, 100, 10000);

        return [
            'supplier_id' => Supplier::factory(),
            'return_number' => $this->faker->unique()->regexify('SR[A-Z]{2}[0-9]{6}'),
            'return_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'status' => $this->faker->randomElement(['draft', 'confirmed', 'cancelled']),
            'total_amount' => $totalAmount,
            'notes' => $this->faker->optional()->paragraph()
        ];
    }

    public function draft()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft'
        ]);
    }

    public function confirmed()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed'
        ]);
    }

    public function cancelled()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled'
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (SupplierReturn $supplierReturn) {
            // Create supplier return items
            $products = Product::inRandomOrder()->limit(rand(1, 5))->get();
            
            $products->each(function ($product) use ($supplierReturn) {
                SupplierReturnItem::factory()->create([
                    'supplier_return_id' => $supplierReturn->id,
                    'product_id' => $product->id
                ]);
            });
        });
    }
};
