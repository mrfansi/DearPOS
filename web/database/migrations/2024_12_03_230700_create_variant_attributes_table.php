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
        Schema::create('variant_attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('variant_id');
            $table->uuid('attribute_id');
            
            $table->string('value', 255)->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('cascade');

            $table->foreign('attribute_id')
                  ->references('id')
                  ->on('product_attributes')
                  ->onDelete('cascade');

            // Unique constraint to prevent duplicate attributes for the same variant
            $table->unique(['variant_id', 'attribute_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_attributes');
    }
};
