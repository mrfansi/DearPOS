<?php

namespace Database\Seeders;

use App\Models\UnitOfMeasure;
use Illuminate\Database\Seeder;

class UnitOfMeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'code' => 'PCS',
                'name' => 'Pieces',
            ],
            [
                'code' => 'BOX',
                'name' => 'Box',
            ],
            [
                'code' => 'KG',
                'name' => 'Kilogram',
            ],
            [
                'code' => 'GR',
                'name' => 'Gram',
            ],
            [
                'code' => 'LTR',
                'name' => 'Liter',
            ],
            [
                'code' => 'ML',
                'name' => 'Milliliter',
            ],
            [
                'code' => 'MTR',
                'name' => 'Meter',
            ],
            [
                'code' => 'CM',
                'name' => 'Centimeter',
            ],
            [
                'code' => 'DZ',
                'name' => 'Dozen',
            ],
            [
                'code' => 'PAK',
                'name' => 'Pack',
            ],
            [
                'code' => 'SET',
                'name' => 'Set',
            ],
            [
                'code' => 'ROLL',
                'name' => 'Roll',
            ],
        ];

        foreach ($units as $unit) {
            UnitOfMeasure::create($unit);
        }
    }
}
