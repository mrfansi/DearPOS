<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pre_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('order_number', 50)->unique();
            $table->uuid('customer_id');
            $table->uuid('pos_counter_id');
            $table->uuid('currency_id');
            
            $table->dateTime('order_date');
            $table->dateTime('expected_date');
            
            $table->decimal('exchange_rate', 15, 4)->default(1);
            $table->decimal('subtotal', 15, 4);
            $table->decimal('discount_amount', 15, 4)->default(0);
            $table->decimal('tax_amount', 15, 4)->default(0);
            $table->decimal('total_amount', 15, 4);
            $table->decimal('deposit_amount', 15, 4)->default(0);
            
            $table->enum('status', [
                'draft', 'confirmed', 'in_progress', 
                'completed', 'cancelled'
            ])->default('draft');
            
            $table->text('notes')->nullable();
            
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('restrict');
            
            $table->foreign('pos_counter_id')
                  ->references('id')
                  ->on('pos_counters')
                  ->onDelete('restrict');
            
            $table->foreign('currency_id')
                  ->references('id')
                  ->on('currencies')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pre_orders');
    }
};
