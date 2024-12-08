<?php

namespace Database\Factories;

use App\Models\PurchaseAudit;
use App\Models\User;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReturn;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseAuditFactory extends Factory
{
    protected $model = PurchaseAudit::class;

    public function definition()
    {
        $auditableTypes = [
            PurchaseOrder::class,
            PurchaseReturn::class,
        ];
        $auditableType = $this->faker->randomElement($auditableTypes);
        $auditable = $auditableType::factory()->create();

        return [
            'auditable_type' => $auditableType,
            'auditable_id' => $auditable->id,
            'event' => $this->faker->randomElement(['created', 'updated', 'deleted', 'status_changed']),
            'old_values' => $this->faker->optional()->passthrough([
                'status' => $this->faker->randomElement(['draft', 'pending', 'approved']),
            ]),
            'new_values' => $this->faker->optional()->passthrough([
                'status' => $this->faker->randomElement(['pending', 'approved', 'completed']),
            ]),
            'user_id' => User::factory(),
        ];
    }

    public function created()
    {
        return $this->state([
            'event' => 'created',
            'old_values' => null,
        ]);
    }

    public function updated()
    {
        return $this->state([
            'event' => 'updated',
            'old_values' => $this->faker->randomElement([
                ['status' => 'draft'],
                ['total_amount' => $this->faker->randomFloat(4, 100, 1000)],
            ]),
            'new_values' => $this->faker->randomElement([
                ['status' => 'pending'],
                ['total_amount' => $this->faker->randomFloat(4, 100, 1000)],
            ]),
        ]);
    }

    public function statusChanged()
    {
        return $this->state([
            'event' => 'status_changed',
            'old_values' => ['status' => 'draft'],
            'new_values' => ['status' => 'approved'],
        ]);
    }
}
