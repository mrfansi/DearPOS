<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\SupplierReturn;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SupplierReturnFactory extends Factory
{
    protected $model = SupplierReturn::class;

    public function definition(): array
    {
        return [
            'status' => $this->faker->word(),
            'reason' => $this->faker->word(),
            'return_date' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'supplier_id' => Supplier::factory(),
        ];
    }
}
