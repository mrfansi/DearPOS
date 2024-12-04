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
        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Transaction Identifiers
            $table->string('transaction_number')->unique();
            $table->uuid('customer_id')->nullable();
            $table->uuid('pos_counter_id');
            $table->uuid('user_id'); // Cashier

            // Transaction Details
            $table->dateTime('transaction_date');
            $table->string('status', 20); // e.g., pending, completed, cancelled

            // Financial Details
            $table->uuid('currency_id');
            $table->decimal('total_amount', 15, 4);
            $table->decimal('subtotal', 15, 4);
            $table->decimal('tax_amount', 15, 4);
            $table->decimal('discount_amount', 15, 4)->default(0);

            // Payment Status
            $table->string('payment_status', 20); // e.g., unpaid, partial, paid

            // Void Transaction
            $table->boolean('is_void')->default(false);
            $table->text('void_reason')->nullable();

            // Reservation Details
            $table->boolean('is_reservation')->default(false);
            $table->dateTime('reservation_date')->nullable();

            // Additional Information
            $table->text('notes')->nullable();

            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->nullOnDelete();

            $table->foreign('pos_counter_id')
                ->references('id')
                ->on('pos_counters')
                ->onDelete('restrict');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('sales_transactions');
    }
};
