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
        Schema::create('recipe_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('recipe_id');
            $table->uuid('ingredient_id');
            
            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');
            
            $table->boolean('is_optional')->default(false);
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('recipe_id')
                  ->references('id')
                  ->on('product_recipes')
                  ->onDelete('cascade');

            $table->foreign('ingredient_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');

            $table->foreign('unit_id')
                  ->references('id')
                  ->on('units_of_measures')
                  ->onDelete('restrict');

            // Unique constraint to prevent duplicate ingredients in a recipe
            $table->unique(['recipe_id', 'ingredient_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_items');
    }
};
