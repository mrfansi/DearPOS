<?php

namespace Database\Factories;

use App\Helpers\Generator;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'code' => Generator::uniqueNumber(),
            'name' => $this->faker->company(),
            'email' => $this->faker->unique()->email,
            'password' => Hash::make('password'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Tenant $tenant) {
            $tenant->domains()->create([
                'domain' => str()->slug($tenant->name),
            ]);
        });
    }
}
