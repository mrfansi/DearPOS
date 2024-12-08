<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReceiptsTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_receipts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('receipt_number', 50)->unique();
            $table->uuid('purchase_order_id');
            $table->date('receipt_date');
            $table->enum('status', ['draft', 'confirmed', 'cancelled']);
            $table->text('notes')->nullable();
            $table->uuid('received_by');
            
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->foreign('received_by')->references('id')->on('users');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_receipts');
    }
}
