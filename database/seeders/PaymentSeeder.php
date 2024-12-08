<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\SalesTransaction;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Retrieve sales transactions
        $salesTransactions = SalesTransaction::all();

        // Ensure we have currencies
        $currency = Currency::where('code', 'USD')->first()
            ?? Currency::first()
            ?? Currency::factory()->create(['code' => 'USD']);

        // Create some sample payments
        foreach ($salesTransactions as $transaction) {
            $paymentMethod = PaymentMethod::inRandomOrder()->first()
                ?? PaymentMethod::factory()->create();

            Payment::factory()->create([
                'sales_transaction_id' => $transaction->id,
                'payment_method_id' => $paymentMethod->id,
                'currency_id' => $currency->id,
            ]);
        }
    }
}
