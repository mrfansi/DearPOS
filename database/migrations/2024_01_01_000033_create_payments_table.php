<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sales_transaction_id');
            $table->uuid('payment_method_id');
            $table->decimal('amount', 15, 4);
            $table->uuid('currency_id');
            $table->decimal('exchange_rate', 15, 4)->default(1);
            $table->string('status', 20);
            $table->dateTime('payment_date');
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_partial')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sales_transaction_id')->references('id')->on('sales_transactions');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
