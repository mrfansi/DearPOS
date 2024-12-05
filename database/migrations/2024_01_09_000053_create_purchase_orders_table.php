<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('supplier_id');
            $table->string('order_number', 50)->unique();
            $table->date('order_date');
            $table->date('expected_delivery_date')->nullable();
            
            $table->string('status', 20);
            $table->string('payment_status', 20);
            
            $table->decimal('total_amount', 15, 4);
            $table->decimal('paid_amount', 15, 4)->default(0);
            
            $table->text('notes')->nullable();
            $table->uuid('created_by');
            
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
        Schema::dropIfExists('purchase_orders');
    }
};
