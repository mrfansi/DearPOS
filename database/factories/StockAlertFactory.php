<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockAlert;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockAlertFactory extends Factory
{
    protected $model = StockAlert::class;

    public function definition(): array
    {
        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();
        $threshold = $this->faker->randomFloat(4, 10, 100);
        $current = $this->faker->randomFloat(4, 0, 150);

        return [
            'product_id' => $product->id,
            'product_variant_id' => $this->faker->boolean(30) ? ProductVariant::factory()->create(['product_id' => $product->id])->id : null,
            'warehouse_id' => $warehouse->id,
            'alert_type' => $this->faker->randomElement(['low_stock', 'overstock', 'expiring']),
            'threshold_quantity' => $threshold,
            'current_quantity' => $current,
            'status' => $this->faker->randomElement(['active', 'resolved', 'ignored']),
            'is_notification_sent' => $this->faker->boolean,
            'notification_date' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'resolved_by' => $this->faker->boolean(30) ? User::factory()->create()->id : null,
            'resolved_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'notes' => $this->faker->optional()->sentence
        ];
    }

    public function lowStock()
    {
        return $this->state([
            'alert_type' => 'low_stock',
            'current_quantity' => $this->faker->randomFloat(4, 0, 10)
        ]);
    }

    public function overstock()
    {
        return $this->state([
            'alert_type' => 'overstock',
            'current_quantity' => $this->faker->randomFloat(4, 100, 200)
        ]);
    }

    public function expiring()
    {
        return $this->state([
            'alert_type' => 'expiring'
        ]);
    }

    public function active()
    {
        return $this->state([
            'status' => 'active',
            'resolved_by' => null,
            'resolved_at' => null
        ]);
    }

    public function resolved()
    {
        return $this->state(function (array $attributes) {
            $user = User::factory()->create();
            return [
                'status' => 'resolved',
                'resolved_by' => $user->id,
                'resolved_at' => now()
            ];
        });
    }

    public function ignored()
    {
        return $this->state(function (array $attributes) {
            $user = User::factory()->create();
            return [
                'status' => 'ignored',
                'resolved_by' => $user->id,
                'resolved_at' => now()
            ];
        });
    }
}
