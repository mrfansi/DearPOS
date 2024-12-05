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
        Schema::create('supplier_return_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('supplier_return_id');
            $table->uuid('product_id');
            $table->integer('quantity');
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('supplier_return_id')
                ->references('id')
                ->on('supplier_returns')
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
        Schema::dropIfExists('supplier_return_items');
    }
};
