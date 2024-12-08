<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReceiptItemsTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_receipt_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('receipt_id');
            $table->uuid('purchase_order_item_id');
            $table->decimal('quantity_received', 15, 4);
            $table->string('lot_number', 50)->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('notes')->nullable();
            
            $table->foreign('receipt_id')->references('id')->on('purchase_receipts');
            $table->foreign('purchase_order_item_id')->references('id')->on('purchase_order_items');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_receipt_items');
    }
}
