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
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Transaction and Product References
            $table->uuid('sales_transaction_id');
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            
            // Quantity and Pricing
            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');
            $table->decimal('unit_price', 15, 4);
            $table->decimal('total_price', 15, 4);
            
            // Discounts and Taxes
            $table->decimal('discount_amount', 15, 4)->default(0);
            $table->decimal('tax_amount', 15, 4)->default(0);
            
            // Additional Information
            $table->text('notes')->nullable();
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('sales_transaction_id')
                  ->references('id')
                  ->on('sales_transactions')
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
        Schema::dropIfExists('transaction_items');
    }
};
