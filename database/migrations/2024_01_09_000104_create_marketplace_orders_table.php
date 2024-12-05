<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marketplace_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('marketplace_store_id');
            $table->uuid('customer_id')->nullable();
            
            $table->string('marketplace_order_id', 100)->unique();
            $table->string('order_number', 50);
            
            $table->enum('status', [
                'pending', 'processing', 'shipped', 
                'delivered', 'cancelled', 'refunded'
            ])->default('pending');
            
            $table->dateTime('order_date');
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            
            $table->decimal('subtotal', 15, 4);
            $table->decimal('shipping_cost', 15, 4);
            $table->decimal('tax', 15, 4);
            $table->decimal('total', 15, 4);
            
            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();
            
            $table->json('additional_info')->nullable();
            
            $table->foreign('marketplace_store_id')
                  ->references('id')
                  ->on('marketplace_stores')
                  ->onDelete('restrict');
            
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketplace_orders');
    }
};
