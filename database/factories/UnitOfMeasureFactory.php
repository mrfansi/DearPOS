<?php

namespace Database\Factories;

use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitOfMeasure>
 */
class UnitOfMeasureFactory extends Factory
{
    protected $model = UnitOfMeasure::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $units = ['PCS', 'BOX', 'KG', 'GR', 'LTR', 'ML', 'MTR', 'CM'];
        $names = [
            'Pieces', 'Box', 'Kilogram', 'Gram',
            'Liter', 'Milliliter', 'Meter', 'Centimeter',
        ];

        $index = array_rand($units);

        return [
            'code' => $units[$index],
            'name' => $names[$index],
        ];
    }
}
