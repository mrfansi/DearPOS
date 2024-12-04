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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->string('sku', 50);
            $table->text('description')->nullable();

            $table->uuid('category_id');
            $table->uuid('base_currency_id');
            $table->uuid('base_unit_id');

            $table->boolean('is_managed_by_recipe')->default(false);
            $table->boolean('track_expiry')->default(false);
            $table->boolean('track_serial')->default(false);

            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories')
                ->cascadeOnDelete();

            $table->foreign('base_currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('restrict');

            $table->foreign('base_unit_id')
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
        Schema::dropIfExists('products');
    }
};
