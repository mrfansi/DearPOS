<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sales_transaction_id')->constrained();
            $table->foreignUuid('payment_method_id')->constrained();
            $table->decimal('amount', 15, 4);
            $table->foreignUuid('currency_id')->constrained();
            $table->decimal('exchange_rate', 15, 4)->default(1);
            $table->enum('status', ['pending', 'completed', 'failed']);
            $table->dateTime('payment_date');
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_partial')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('sales_transaction_id');
            $table->index('payment_method_id');
            $table->index('reference_number');
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
