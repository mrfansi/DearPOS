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
        Schema::create('coupons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Basic Information
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            
            // Coupon Configuration
            $table->string('type'); // percentage, fixed_amount
            $table->decimal('value', 15, 4);
            
            // Constraints
            $table->decimal('minimum_purchase_amount', 15, 4)->default(0);
            $table->decimal('maximum_coupon_amount', 15, 4)->nullable();
            
            // Validity Period
            $table->date('start_date');
            $table->date('end_date');
            
            // Usage Limits
            $table->integer('usage_limit')->nullable(); // Total times coupon can be used
            $table->integer('per_customer_limit')->nullable(); // Times per customer
            
            // Status
            $table->boolean('is_active')->default(true);
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot table for products
        Schema::create('coupon_products', function (Blueprint $table) {
            $table->uuid('coupon_id');
            $table->uuid('product_id');
            
            $table->primary(['coupon_id', 'product_id']);
            
            $table->foreign('coupon_id')
                  ->references('id')
                  ->on('coupons')
                  ->onDelete('cascade');
            
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });

        // Pivot table for categories
        Schema::create('coupon_categories', function (Blueprint $table) {
            $table->uuid('coupon_id');
            $table->uuid('category_id');
            
            $table->primary(['coupon_id', 'category_id']);
            
            $table->foreign('coupon_id')
                  ->references('id')
                  ->on('coupons')
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
        Schema::dropIfExists('coupon_categories');
        Schema::dropIfExists('coupon_products');
        Schema::dropIfExists('coupons');
    }
};
