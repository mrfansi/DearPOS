<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsReceiptsTable extends Migration
{
    public function up()
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('purchase_order_id');
            $table->string('receipt_number', 50)->unique();
            $table->date('receipt_date');
            $table->enum('status', ['draft', 'confirmed', 'cancelled']);
            $table->text('notes')->nullable();

            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('goods_receipts');
    }
}
