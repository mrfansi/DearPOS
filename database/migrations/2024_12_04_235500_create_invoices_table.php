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
            // Invoices Table
            Schema::create('invoices', function (Blueprint $table) {
                  $table->uuid('id')->primary();

                  // Invoice Identifiers
                  $table->string('invoice_number')->unique();
                  $table->uuid('sales_transaction_id')->nullable();
                  $table->uuid('customer_id')->nullable();
                  $table->uuid('branch_id');
                  $table->uuid('pos_counter_id');

                  // Timing Details
                  $table->date('invoice_date');
                  $table->date('due_date');

                  // Status and Payment Details
                  $table->string('status', 50); // draft, issued, paid, overdue, cancelled
                  $table->string('payment_status', 50); // unpaid, partial, paid

                  // Financial Details
                  $table->decimal('total_amount', 15, 4);
                  $table->decimal('subtotal', 15, 4);
                  $table->decimal('tax_amount', 15, 4)->nullable();
                  $table->decimal('discount_amount', 15, 4)->nullable();
                  $table->decimal('additional_charges', 15, 4)->nullable();

                  // Tax Information
                  $table->boolean('is_taxable')->default(false);
                  $table->decimal('tax_rate', 5, 2)->nullable();

                  // Additional Details
                  $table->text('notes')->nullable();
                  $table->uuid('created_by');

                  // Tracking Timestamps
                  $table->timestamp('printed_at')->nullable();
                  $table->timestamp('sent_at')->nullable();

                  // Timestamps and Soft Delete
                  $table->timestamps();
                  $table->softDeletes();

                  // Foreign Key Constraints
                  $table->foreign('sales_transaction_id')
                        ->references('id')
                        ->on('sales_transactions')
                        ->nullOnDelete();

                  $table->foreign('customer_id')
                        ->references('id')
                        ->on('customers')
                        ->nullOnDelete();

                  $table->foreign('branch_id')
                        ->references('id')
                        ->on('branches')
                        ->onDelete('restrict');

                  $table->foreign('pos_counter_id')
                        ->references('id')
                        ->on('pos_counters')
                        ->onDelete('restrict');

                  $table->foreign('created_by')
                        ->references('id')
                        ->on('users')
                        ->onDelete('restrict');
            });

            // Invoice Items Table
            Schema::create('invoice_items', function (Blueprint $table) {
                  $table->uuid('id')->primary();

                  // Invoice and Product References
                  $table->uuid('invoice_id');
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

                  // Additional Details
                  $table->text('notes')->nullable();

                  // Timestamps and Soft Delete
                  $table->timestamps();
                  $table->softDeletes();

                  // Foreign Key Constraints
                  $table->foreign('invoice_id')
                        ->references('id')
                        ->on('invoices')
                        ->cascadeOnDelete();

                  $table->foreign('product_id')
                        ->references('id')
                        ->on('products')
                        ->onDelete('restrict');

                  $table->foreign('product_variant_id')
                        ->references('id')
                        ->on('product_variants')
                        ->nullOnDelete();

                  $table->foreign('unit_id')
                        ->references('id')
                        ->on('units_of_measures')
                        ->onDelete('restrict');
            });

            // Split Payments Table
            Schema::create('split_payments', function (Blueprint $table) {
                  $table->uuid('id')->primary();

                  // Payment References
                  $table->uuid('invoice_id');
                  $table->uuid('payment_method_id');

                  // Payment Details
                  $table->decimal('amount', 15, 4);
                  $table->dateTime('payment_date');
                  $table->string('reference_number')->nullable();
                  $table->string('status', 50); // pending, completed, failed
                  $table->string('payment_type', 50); // cash, card, bank_transfer, digital_wallet

                  // Optional Customer and POS Details
                  $table->uuid('customer_id')->nullable();
                  $table->uuid('pos_counter_id');

                  // Additional Details
                  $table->uuid('created_by');
                  $table->text('notes')->nullable();

                  // Timestamps and Soft Delete
                  $table->timestamps();
                  $table->softDeletes();

                  // Foreign Key Constraints
                  $table->foreign('invoice_id')
                        ->references('id')
                        ->on('invoices')
                        ->cascadeOnDelete();

                  $table->foreign('payment_method_id')
                        ->references('id')
                        ->on('payment_methods')
                        ->onDelete('restrict');

                  $table->foreign('customer_id')
                        ->references('id')
                        ->on('customers')
                        ->nullOnDelete();

                  $table->foreign('pos_counter_id')
                        ->references('id')
                        ->on('pos_counters')
                        ->onDelete('restrict');

                  $table->foreign('created_by')
                        ->references('id')
                        ->on('users')
                        ->onDelete('restrict');
            });
      }

      /**
       * Reverse the migrations.
       */
      public function down(): void
      {
            Schema::dropIfExists('split_payments');
            Schema::dropIfExists('invoice_items');
            Schema::dropIfExists('invoices');
      }
};
