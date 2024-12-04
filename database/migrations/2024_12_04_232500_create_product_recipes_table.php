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
        Schema::create('product_recipes', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('product_id');
            $table->string('name', 100);
            $table->text('description')->nullable();

            $table->decimal('yield_quantity', 15, 4);
            $table->uuid('yield_unit_id');

            $table->decimal('preparation_time', 10, 2)->nullable(); // in minutes
            $table->decimal('cooking_time', 10, 2)->nullable(); // in minutes

            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();

            $table->foreign('yield_unit_id')
                ->references('id')
                ->on('units_of_measures')
                ->onDelete('restrict');

            // Unique constraint for recipe name per product
            $table->unique(['product_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_recipes');
    }
};
