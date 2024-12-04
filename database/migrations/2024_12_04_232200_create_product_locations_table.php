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
        Schema::create('product_locations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('product_id');
            $table->uuid('variant_id')->nullable();
            $table->uuid('location_id');

            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');

            $table->decimal('min_stock_level', 15, 4)->nullable();
            $table->decimal('max_stock_level', 15, 4)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();

            $table->foreign('variant_id')
                ->references('id')
                ->on('product_variants')
                ->cascadeOnDelete();

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');

            $table->foreign('unit_id')
                ->references('id')
                ->on('units_of_measures')
                ->onDelete('restrict');

            // Unique constraint to prevent duplicate product-location combinations
            $table->unique(['product_id', 'variant_id', 'location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_locations');
    }
};
