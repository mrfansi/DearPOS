<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('purchase_order_id');
            $table->uuid('product_id');
            $table->uuid('variant_id')->nullable();
            $table->decimal('quantity', 15, 4);
            $table->decimal('received_quantity', 15, 4)->default(0);
            $table->uuid('unit_id');
            $table->decimal('unit_price', 15, 4);
            $table->decimal('tax_amount', 15, 4);
            $table->decimal('discount_amount', 15, 4);
            $table->decimal('total_amount', 15, 4);
            $table->text('notes')->nullable();

            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('variant_id')->references('id')->on('product_variants');
            $table->foreign('unit_id')->references('id')->on('units_of_measures');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_order_items');
    }
}
