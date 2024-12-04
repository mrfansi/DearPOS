<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reconciliation_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('bank_statement_id');
            $table->uuid('transaction_id')->nullable();
            $table->string('transaction_type', 50)->nullable();
            $table->decimal('bank_amount', 15, 4);
            $table->decimal('system_amount', 15, 4);
            $table->enum('status', ['matched', 'unmatched', 'partially_matched'])->default('unmatched');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bank_statement_id')->references('id')->on('bank_statements');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reconciliation_items');
    }
};
