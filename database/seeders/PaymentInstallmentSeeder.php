<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\PaymentInstallment;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class PaymentInstallmentSeeder extends Seeder
{
    public function run(): void
    {
        // Retrieve payments
        $payments = Payment::all();

        // Ensure we have currencies
        $currency = Currency::where('code', 'USD')->first() 
            ?? Currency::first() 
            ?? Currency::factory()->create(['code' => 'USD']);

        // Create payment installments for each payment
        foreach ($payments as $payment) {
            // Randomly decide whether to create installments
            if (rand(0, 1)) {
                $installmentCount = rand(1, 5);
                $totalAmount = $payment->amount;
                $remainingAmount = $totalAmount;

                for ($i = 0; $i < $installmentCount; $i++) {
                    $installmentAmount = $i === $installmentCount - 1 
                        ? $remainingAmount 
                        : rand(10, (int)$remainingAmount);

                    PaymentInstallment::factory()->create([
                        'payment_id' => $payment->id,
                        'currency_id' => $currency->id,
                        'amount' => $installmentAmount,
                        'due_date' => now()->addDays(30 * ($i + 1)),
                    ]);

                    $remainingAmount -= $installmentAmount;
                }
            }
        }
    }
};
