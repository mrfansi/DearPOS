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
        Schema::create('refunds', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Transaction References
            $table->uuid('sales_transaction_id');
            $table->uuid('payment_id');

            // Refund Details
            $table->string('refund_number')->unique();
            $table->decimal('total_refund_amount', 15, 4);

            // Reason and Status
            $table->text('reason')->nullable();
            $table->string('status', 20); // pending, processed, rejected
            $table->string('refund_method', 20); // original_payment, store_credit, cash

            // Processing Information
            $table->uuid('processed_by')->nullable();
            $table->dateTime('processed_at')->nullable();

            // Additional Notes
            $table->text('notes')->nullable();

            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('sales_transaction_id')
                ->references('id')
                ->on('sales_transactions')
                ->cascadeOnDelete();

            $table->foreign('payment_id')
                ->references('id')
                ->on('payments')
                ->cascadeOnDelete();

            $table->foreign('processed_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });

        // Refund Items Table
        Schema::create('refund_items', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Refund and Product References
            $table->uuid('refund_id');
            $table->uuid('transaction_item_id');

            // Quantity and Pricing
            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_price', 15, 4);
            $table->decimal('total_price', 15, 4);

            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('refund_id')
                ->references('id')
                ->on('refunds')
                ->cascadeOnDelete();

            $table->foreign('transaction_item_id')
                ->references('id')
                ->on('transaction_items')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_items');
        Schema::dropIfExists('refunds');
    }
};
