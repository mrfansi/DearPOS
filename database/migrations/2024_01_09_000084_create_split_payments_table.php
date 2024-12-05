<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('split_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('sales_transaction_id');
            $table->uuid('payment_method_id');
            
            $table->decimal('amount', 15, 4);
            $table->string('status', 20);
            
            $table->text('notes')->nullable();
            
            $table->foreign('sales_transaction_id')
                  ->references('id')
                  ->on('sales_transactions')
                  ->onDelete('cascade');
            
            $table->foreign('payment_method_id')
                  ->references('id')
                  ->on('payment_methods')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('split_payments');
    }
};
