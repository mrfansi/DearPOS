<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsReceiptItemsTable extends Migration
{
    public function up()
    {
        Schema::create('goods_receipt_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('goods_receipt_id');
            $table->uuid('purchase_order_item_id');
            $table->uuid('product_id');
            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_cost', 15, 4);
            $table->decimal('total_amount', 15, 4);
            $table->text('notes')->nullable();

            $table->foreign('goods_receipt_id')->references('id')->on('goods_receipts');
            $table->foreign('purchase_order_item_id')->references('id')->on('purchase_order_items');
            $table->foreign('product_id')->references('id')->on('products');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('goods_receipt_items');
    }
}
