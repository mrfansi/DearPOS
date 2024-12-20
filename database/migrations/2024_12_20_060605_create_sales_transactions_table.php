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
        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transaction_number', 50)->unique();
            $table->foreignUuid('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignUuid('pos_counter_id')->constrained();
            $table->foreignUuid('currency_id')->constrained();
            $table->dateTime('transaction_date');
            $table->decimal('subtotal', 15, 4);
            $table->decimal('tax_amount', 15, 4);
            $table->decimal('discount_amount', 15, 4);
            $table->decimal('total_amount', 15, 4);
            $table->enum('payment_status', ['unpaid', 'partial', 'paid']);
            $table->enum('status', ['draft', 'completed', 'voided']);
            $table->text('notes')->nullable();
            $table->foreignUuid('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('customer_id');
            $table->index('pos_counter_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_transactions');
    }
};
