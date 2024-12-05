<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('purchase_order_id');
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            
            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');
            
            $table->decimal('unit_cost', 15, 4);
            $table->decimal('total_cost', 15, 4);
            
            $table->text('notes')->nullable();
            
            $table->foreign('purchase_order_id')
                  ->references('id')
                  ->on('purchase_orders')
                  ->onDelete('cascade');
            
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('restrict');
            
            $table->foreign('product_variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('set null');
            
            $table->foreign('unit_id')
                  ->references('id')
                  ->on('units_of_measures')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
