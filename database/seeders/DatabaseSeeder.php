<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\UnitOfMeasureSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@dearpos.com',
        ]);

        // Seed core tables
        $this->call([
            CurrencySeeder::class,
            UnitOfMeasureSeeder::class,
            LocationSeeder::class,
        ]);
    }
}
