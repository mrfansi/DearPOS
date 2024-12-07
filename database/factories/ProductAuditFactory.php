<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductAudit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAudit>
 */
class ProductAuditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductAudit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::factory()->create();
        $event = fake()->randomElement(['created', 'updated', 'deleted', 'status_changed', 'price_changed']);
        
        return [
            'auditable_type' => Product::class,
            'auditable_id' => $product->id,
            'event' => $event,
            'old_values' => $this->getOldValues($event),
            'new_values' => $this->getNewValues($event),
            'user_id' => User::factory(),
            'created_at' => fake()->dateTimeThisYear(),
        ];
    }

    /**
     * Get old values based on event type.
     */
    private function getOldValues(string $event): array
    {
        return match ($event) {
            'created' => [],
            'updated' => ['name' => fake()->words(3, true)],
            'deleted' => ['deleted_at' => null],
            'status_changed' => ['status' => 'draft'],
            'price_changed' => ['selling_price' => fake()->randomFloat(4, 10, 1000)],
            default => [],
        };
    }

    /**
     * Get new values based on event type.
     */
    private function getNewValues(string $event): array
    {
        return match ($event) {
            'created' => ['name' => fake()->words(3, true)],
            'updated' => ['name' => fake()->words(3, true)],
            'deleted' => ['deleted_at' => now()],
            'status_changed' => ['status' => 'active'],
            'price_changed' => ['selling_price' => fake()->randomFloat(4, 10, 1000)],
            default => [],
        };
    }
}
