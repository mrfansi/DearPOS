<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supplier_return_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('supplier_return_id');
            $table->uuid('goods_receipt_item_id')->nullable();
            
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            
            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');
            
            $table->decimal('unit_cost', 15, 4);
            $table->decimal('total_cost', 15, 4);
            
            $table->text('reason')->nullable();
            
            $table->foreign('supplier_return_id')
                  ->references('id')
                  ->on('supplier_returns')
                  ->onDelete('cascade');
            
            $table->foreign('goods_receipt_item_id')
                  ->references('id')
                  ->on('goods_receipt_items')
                  ->onDelete('set null');
            
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
        Schema::dropIfExists('supplier_return_items');
    }
};
