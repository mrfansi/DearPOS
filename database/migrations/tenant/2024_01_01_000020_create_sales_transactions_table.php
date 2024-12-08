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
            $table->foreignUuid('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignUuid('pos_counter_id')->constrained('pos_counters')->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete();
            $table->dateTime('transaction_date');
            $table->decimal('subtotal', 15, 4);
            $table->decimal('tax_amount', 15, 4);
            $table->decimal('discount_amount', 15, 4);
            $table->decimal('total_amount', 15, 4);
            $table->string('payment_status', 20); // unpaid, partial, paid
            $table->string('status', 20); // draft, completed, voided
            $table->text('notes')->nullable();
            $table->foreignUuid('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
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
