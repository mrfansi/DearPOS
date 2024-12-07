<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_installments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('payment_id');
            $table->uuid('currency_id');
            $table->integer('installment_number');
            $table->decimal('amount', 15, 4);
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->string('status', 20);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_installments');
    }
};
