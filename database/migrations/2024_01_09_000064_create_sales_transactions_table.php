<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('transaction_number', 50)->unique();
            $table->dateTime('transaction_date');
            
            $table->uuid('customer_id')->nullable();
            $table->uuid('pos_counter_id');
            $table->uuid('cashier_id');
            $table->uuid('currency_id');
            
            $table->decimal('exchange_rate', 15, 4)->default(1);
            $table->decimal('subtotal', 15, 4);
            $table->decimal('discount_amount', 15, 4)->default(0);
            $table->decimal('tax_amount', 15, 4)->default(0);
            $table->decimal('total_amount', 15, 4);
            $table->decimal('paid_amount', 15, 4)->default(0);
            $table->decimal('change_amount', 15, 4)->default(0);
            
            $table->enum('status', ['draft', 'completed', 'voided'])->default('draft');
            
            $table->text('notes')->nullable();
            
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('set null');
            
            $table->foreign('pos_counter_id')
                  ->references('id')
                  ->on('pos_counters')
                  ->onDelete('restrict');
            
            $table->foreign('cashier_id')
                  ->references('id')
                  ->on('users')
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
        Schema::dropIfExists('sales_transactions');
    }
};
