<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marketplace_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('marketplace_order_id');
            $table->uuid('product_marketplace_mapping_id');
            
            $table->string('marketplace_order_item_id', 100)->unique();
            
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 4);
            $table->decimal('total_price', 15, 4);
            
            $table->enum('status', [
                'pending', 'processing', 'shipped', 
                'delivered', 'cancelled', 'refunded'
            ])->default('pending');
            
            $table->json('additional_info')->nullable();
            
            $table->foreign('marketplace_order_id')
                  ->references('id')
                  ->on('marketplace_orders')
                  ->onDelete('cascade');
            
            $table->foreign('product_marketplace_mapping_id')
                  ->references('id')
                  ->on('product_marketplace_mappings')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketplace_order_items');
    }
};
