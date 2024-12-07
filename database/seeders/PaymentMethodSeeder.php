<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        // Predefined payment methods
        $methods = [
            [
                'code' => 'CASH001',
                'name' => 'Cash',
                'description' => 'Direct cash payment',
                'is_cash' => true,
                'is_card' => false,
                'is_digital' => false
            ],
            [
                'code' => 'CCARD001',
                'name' => 'Credit Card',
                'description' => 'Credit card payment',
                'is_cash' => false,
                'is_card' => true,
                'is_digital' => false
            ],
            [
                'code' => 'DCARD001',
                'name' => 'Debit Card',
                'description' => 'Debit card payment',
                'is_cash' => false,
                'is_card' => true,
                'is_digital' => false
            ],
            [
                'code' => 'BANK001',
                'name' => 'Bank Transfer',
                'description' => 'Direct bank transfer',
                'is_cash' => false,
                'is_card' => false,
                'is_digital' => true
            ],
            [
                'code' => 'EWALLET001',
                'name' => 'E-Wallet',
                'description' => 'Digital wallet payment',
                'is_cash' => false,
                'is_card' => false,
                'is_digital' => true
            ]
        ];

        foreach ($methods as $methodData) {
            PaymentMethod::firstOrCreate(
                ['code' => $methodData['code']],
                $methodData
            );
        }

        // Add some random additional payment methods
        PaymentMethod::factory()->count(3)->create();
    }
};
