<?php

namespace App\Actions\Bank;

use App\Models\BankStatement;
use Illuminate\Support\Str;

class CreateBankStatementAction
{
    public function execute(array $data): BankStatement
    {
        return BankStatement::create([
            'id' => Str::uuid(),
            'bank_account_id' => $data['bank_account_id'],
            'statement_date' => $data['statement_date'],
            'opening_balance' => $data['opening_balance'],
            'closing_balance' => $data['closing_balance'],
            'total_credits' => $data['total_credits'],
            'total_debits' => $data['total_debits'],
            'statement_file_path' => $data['statement_file_path'] ?? null,
            'status' => $data['status'] ?? 'pending'
        ]);
    }
} 