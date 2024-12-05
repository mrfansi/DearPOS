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
        Schema::create('bundle_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('bundle_id');
            $table->uuid('product_id');
            $table->integer('quantity');
            $table->decimal('price_adjustment', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bundle_id')
                ->references('id')
                ->on('product_bundles')
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
        Schema::dropIfExists('bundle_items');
    }
};
