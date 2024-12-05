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
            $table->uuid('product_id');
            $table->decimal('quantity', 10, 2);
            $table->string('unit');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('recipe_id')
                ->references('id')
                ->on('product_recipes')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
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
