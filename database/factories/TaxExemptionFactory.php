<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\TaxExemption;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class TaxExemptionFactory extends Factory
{
    protected $model = TaxExemption::class;

    public function definition(): array
    {
        $validFrom = fake()->dateTimeBetween('-1 year', 'now');
        $validUntil = fake()->dateTimeBetween($validFrom, '+2 years');

        // Simulate document upload
        $documentPath = 'tax_exemptions/' . fake()->uuid() . '.pdf';
        Storage::put($documentPath, fake()->text());

        return [
            'customer_id' => Customer::factory(),
            'tax_number' => fake()->unique()->numerify('TAX-###-###-###'),
            'document_path' => $documentPath,
            'valid_from' => $validFrom,
            'valid_until' => $validUntil,
        ];
    }

    public function active(): static
    {
        return $this->state([
            'valid_from' => now()->subMonths(6),
            'valid_until' => now()->addMonths(6),
        ]);
    }

    public function expired(): static
    {
        return $this->state([
            'valid_from' => now()->subYears(2),
            'valid_until' => now()->subMonths(6),
        ]);
    }

    public function future(): static
    {
        return $this->state([
            'valid_from' => now()->addMonths(1),
            'valid_until' => now()->addYears(1),
        ]);
    }

    public function longTerm(): static
    {
        return $this->state([
            'valid_from' => now()->subYear(),
            'valid_until' => now()->addYears(5),
        ]);
    }
}
