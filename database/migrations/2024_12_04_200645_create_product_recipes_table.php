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
            $table->string('name');
            $table->text('instructions');
            $table->decimal('yield_quantity', 10, 2);
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('product_recipes');
    }
};
