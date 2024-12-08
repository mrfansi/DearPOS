<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnItemsTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_return_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('return_id');
            $table->uuid('purchase_order_item_id');
            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_price', 15, 4);
            $table->decimal('total_amount', 15, 4);
            $table->enum('reason', ['defective', 'wrong_item', 'excess_quantity', 'damaged', 'other']);
            $table->text('notes')->nullable();
            
            $table->foreign('return_id')->references('id')->on('purchase_returns');
            $table->foreign('purchase_order_item_id')->references('id')->on('purchase_order_items');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_return_items');
    }
}
