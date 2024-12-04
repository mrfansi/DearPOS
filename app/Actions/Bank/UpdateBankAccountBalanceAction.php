<?php

namespace App\Actions\Bank;

use App\Models\BankAccount;

class UpdateBankAccountBalanceAction
{
    public function execute(BankAccount $account, float $amount, string $operation = 'credit'): BankAccount
    {
        if ($operation === 'credit') {
            $account->increment('current_balance', $amount);
        } else {
            $account->decrement('current_balance', $amount);
        }

        return $account->fresh();
    }
} 