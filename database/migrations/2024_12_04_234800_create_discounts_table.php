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
        Schema::create('discounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Basic Information
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            
            // Discount Configuration
            $table->string('type'); // percentage, fixed_amount, buy_x_get_y
            $table->decimal('value', 15, 4);
            
            // Constraints
            $table->decimal('minimum_purchase_amount', 15, 4)->default(0);
            $table->decimal('maximum_discount_amount', 15, 4)->nullable();
            
            // Validity Period
            $table->date('start_date');
            $table->date('end_date');
            
            // Application Scope
            $table->string('applies_to'); // all_products, specific_products, specific_categories
            $table->boolean('is_active')->default(true);
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot table for products
        Schema::create('discount_products', function (Blueprint $table) {
            $table->uuid('discount_id');
            $table->uuid('product_id');
            
            $table->primary(['discount_id', 'product_id']);
            
            $table->foreign('discount_id')
                  ->references('id')
                  ->on('discounts')
                  ->onDelete('cascade');
            
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });

        // Pivot table for categories
        Schema::create('discount_categories', function (Blueprint $table) {
            $table->uuid('discount_id');
            $table->uuid('category_id');
            
            $table->primary(['discount_id', 'category_id']);
            
            $table->foreign('discount_id')
                  ->references('id')
                  ->on('discounts')
                  ->onDelete('cascade');
            
            $table->foreign('category_id')
                  ->references('id')
                  ->on('product_categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_categories');
        Schema::dropIfExists('discount_products');
        Schema::dropIfExists('discounts');
    }
};
