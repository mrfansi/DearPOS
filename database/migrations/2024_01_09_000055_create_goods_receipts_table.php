<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('purchase_order_id')->nullable();
            $table->uuid('supplier_id');
            
            $table->string('receipt_number', 50)->unique();
            $table->date('receipt_date');
            
            $table->string('status', 20);
            
            $table->decimal('total_amount', 15, 4);
            
            $table->text('notes')->nullable();
            $table->uuid('created_by');
            
            $table->foreign('purchase_order_id')
                  ->references('id')
                  ->on('purchase_orders')
                  ->onDelete('set null');
            
            $table->foreign('supplier_id')
                  ->references('id')
                  ->on('suppliers')
                  ->onDelete('restrict');
            
            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('goods_receipts');
    }
};
