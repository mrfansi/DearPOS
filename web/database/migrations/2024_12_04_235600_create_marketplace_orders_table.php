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
        // Marketplaces Table
        Schema::create('marketplaces', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Marketplace Details
            $table->string('name');
            $table->string('platform_code')->unique();
            $table->decimal('commission_rate', 5, 2)->nullable();
            
            // API and Integration Details
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->string('webhook_url')->nullable();
            
            // Configuration
            $table->boolean('is_active')->default(true);
            $table->string('sync_frequency', 50)->nullable(); // daily, hourly, realtime
            $table->string('integration_type', 50)->nullable(); // direct, middleware
            
            // Support Information
            $table->string('support_email')->nullable();
            $table->string('support_phone')->nullable();
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();
        });

        // Marketplace Orders Table
        Schema::create('marketplace_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Order Identifiers
            $table->string('order_number')->unique();
            $table->uuid('marketplace_id');
            $table->uuid('customer_id')->nullable();
            $table->uuid('branch_id');
            $table->uuid('sales_transaction_id')->nullable();
            
            // Order Timing
            $table->date('order_date');
            
            // Status and Payment
            $table->string('status', 50); // pending, processing, shipped, delivered, cancelled, returned
            $table->string('payment_status', 50); // unpaid, paid, partial
            $table->string('fulfillment_status', 50); // not_fulfilled, partially_fulfilled, fully_fulfilled
            
            // Financial Details
            $table->decimal('total_amount', 15, 4);
            $table->decimal('subtotal', 15, 4);
            $table->decimal('shipping_amount', 15, 4)->nullable();
            $table->decimal('tax_amount', 15, 4)->nullable();
            $table->decimal('discount_amount', 15, 4)->nullable();
            $table->decimal('marketplace_commission', 15, 4)->nullable();
            
            // Shipping Details
            $table->string('shipping_method')->nullable();
            $table->string('tracking_number')->nullable();
            $table->uuid('shipping_address_id')->nullable();
            $table->uuid('billing_address_id')->nullable();
            
            // Additional Details
            $table->text('notes')->nullable();
            $table->string('external_order_id')->nullable();
            $table->uuid('created_by');
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('marketplace_id')
                  ->references('id')
                  ->on('marketplaces')
                  ->onDelete('restrict');

            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('set null');

            $table->foreign('branch_id')
                  ->references('id')
                  ->on('branches')
                  ->onDelete('restrict');

            $table->foreign('sales_transaction_id')
                  ->references('id')
                  ->on('sales_transactions')
                  ->onDelete('set null');

            $table->foreign('shipping_address_id')
                  ->references('id')
                  ->on('addresses')
                  ->onDelete('set null');

            $table->foreign('billing_address_id')
                  ->references('id')
                  ->on('addresses')
                  ->onDelete('set null');

            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
        });

        // Marketplace Order Items Table
        Schema::create('marketplace_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Order and Product References
            $table->uuid('marketplace_order_id');
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            
            // Quantity and Pricing
            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');
            $table->decimal('unit_price', 15, 4);
            $table->decimal('total_price', 15, 4);
            
            // Discounts and Taxes
            $table->decimal('discount_amount', 15, 4)->nullable();
            $table->decimal('tax_amount', 15, 4)->nullable();
            
            // Fulfillment Status
            $table->string('fulfillment_status', 50); // not_fulfilled, partially_fulfilled, fully_fulfilled
            
            // Additional Details
            $table->string('external_item_id')->nullable();
            $table->text('notes')->nullable();
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('marketplace_order_id')
                  ->references('id')
                  ->on('marketplace_orders')
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

        // Marketplace Order Payments Table
        Schema::create('marketplace_order_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Payment References
            $table->uuid('marketplace_order_id');
            $table->uuid('payment_method_id');
            
            // Payment Details
            $table->decimal('amount', 15, 4);
            $table->dateTime('payment_date');
            $table->string('reference_number')->nullable();
            $table->string('status', 50); // pending, completed, failed
            $table->string('payment_type', 50); // marketplace_payout, customer_payment
            
            // Additional Details
            $table->string('external_payment_id')->nullable();
            $table->text('notes')->nullable();
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('marketplace_order_id')
                  ->references('id')
                  ->on('marketplace_orders')
                  ->onDelete('cascade');

            $table->foreign('payment_method_id')
                  ->references('id')
                  ->on('payment_methods')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketplace_order_payments');
        Schema::dropIfExists('marketplace_order_items');
        Schema::dropIfExists('marketplace_orders');
        Schema::dropIfExists('marketplaces');
    }
};
