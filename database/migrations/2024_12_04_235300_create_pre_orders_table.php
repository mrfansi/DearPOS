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
        Schema::create('pre_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Pre-Order Identifiers
            $table->string('pre_order_number')->unique();
            $table->uuid('customer_id')->nullable();
            $table->uuid('pos_counter_id');
            $table->uuid('sales_transaction_id')->nullable();
            
            // Timing and Delivery
            $table->date('order_date');
            $table->date('expected_delivery_date')->nullable();
            
            // Status and Details
            $table->string('status', 20); // pending, confirmed, processing, completed, cancelled
            $table->string('payment_status', 20); // unpaid, partial, paid
            
            // Financial Details
            $table->decimal('total_amount', 15, 4);
            $table->decimal('deposit_amount', 15, 4)->nullable();
            
            // Additional Information
            $table->text('notes')->nullable();
            
            // Creator
            $table->uuid('created_by');
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('set null');

            $table->foreign('pos_counter_id')
                  ->references('id')
                  ->on('pos_counters')
                  ->onDelete('restrict');

            $table->foreign('sales_transaction_id')
                  ->references('id')
                  ->on('sales_transactions')
                  ->onDelete('set null');

            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
        });

        // Pre-Order Items Table
        Schema::create('pre_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Pre-Order and Product References
            $table->uuid('pre_order_id');
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            
            // Quantity and Pricing
            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');
            $table->decimal('unit_price', 15, 4);
            $table->decimal('total_price', 15, 4);
            
            // Additional Details
            $table->text('special_instructions')->nullable();
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('pre_order_id')
                  ->references('id')
                  ->on('pre_orders')
                  ->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('restrict');

            $table->foreign('product_variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('set null');

            $table->foreign('unit_id')
                  ->references('id')
                  ->on('units_of_measures')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_order_items');
        Schema::dropIfExists('pre_orders');
    }
};
