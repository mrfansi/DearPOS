<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnsTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('return_number', 50)->unique();
            $table->uuid('purchase_order_id');
            $table->uuid('supplier_id');
            $table->date('return_date');
            $table->enum('status', ['draft', 'pending', 'approved', 'completed', 'cancelled']);
            $table->enum('reason', ['defective', 'wrong_item', 'excess_quantity', 'damaged', 'other']);
            $table->decimal('total_amount', 15, 4);
            $table->text('notes')->nullable();
            $table->uuid('created_by');
            $table->uuid('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_returns');
    }
}
