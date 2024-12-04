<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Transaction Reference
            $table->uuid('sales_transaction_id');
            $table->uuid('payment_method_id');
            
            // Payment Details
            $table->decimal('amount', 15, 4);
            $table->uuid('currency_id');
            $table->decimal('exchange_rate', 15, 4)->default(1);
            
            // Status and Timing
            $table->string('status', 20); // pending, completed, failed
            $table->dateTime('payment_date');
            
            // Additional Information
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            
            // Partial Payment Flag
            $table->boolean('is_partial')->default(false);
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('sales_transaction_id')
                  ->references('id')
                  ->on('sales_transactions')
                  ->onDelete('cascade');

            $table->foreign('payment_method_id')
                  ->references('id')
                  ->on('payment_methods')
                  ->onDelete('restrict');

            $table->foreign('currency_id')
                  ->references('id')
                  ->on('currencies')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
