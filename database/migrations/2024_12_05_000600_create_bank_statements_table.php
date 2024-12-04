<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bank_statements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('bank_account_id');
            $table->date('statement_date');
            $table->decimal('opening_balance', 15, 4);
            $table->decimal('closing_balance', 15, 4);
            $table->decimal('total_credits', 15, 4);
            $table->decimal('total_debits', 15, 4);
            $table->string('statement_file_path')->nullable();
            $table->enum('status', ['imported', 'reconciled', 'partially_reconciled'])->default('imported');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bank_account_id')->references('id')->on('bank_accounts');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_statements');
    }
};
