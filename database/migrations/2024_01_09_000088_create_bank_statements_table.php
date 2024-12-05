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
            
            $table->date('transaction_date');
            $table->text('description');
            
            $table->decimal('debit_amount', 15, 4)->default(0);
            $table->decimal('credit_amount', 15, 4)->default(0);
            
            $table->string('reference_number', 100)->nullable();
            
            $table->foreign('bank_account_id')
                  ->references('id')
                  ->on('bank_accounts')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_statements');
    }
};
