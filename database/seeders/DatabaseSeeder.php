<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\CustomerCreditHistorySeeder;
use Database\Seeders\CustomerGroupSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\PosCounterSeeder;
use Database\Seeders\ProductBrandSeeder;
use Database\Seeders\ProductCategorySeeder;
use Database\Seeders\ProductPriceListSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SalesTransactionSeeder;
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
            CustomerGroupSeeder::class,
            CustomerSeeder::class,
            ProductCategorySeeder::class,
            ProductBrandSeeder::class,
            ProductSeeder::class,
            ProductPriceListSeeder::class,
            CustomerCreditHistorySeeder::class,
            PosCounterSeeder::class,
            SalesTransactionSeeder::class,
        ]);
    }
}
