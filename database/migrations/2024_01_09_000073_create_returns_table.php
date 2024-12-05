<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('return_number', 50)->unique();
            
            $table->uuid('sales_transaction_id');
            $table->uuid('customer_id');
            
            $table->dateTime('return_date');
            $table->text('return_reason');
            
            $table->decimal('total_amount', 15, 4);
            $table->string('status', 20);
            
            $table->text('notes')->nullable();
            
            $table->foreign('sales_transaction_id')
                  ->references('id')
                  ->on('sales_transactions')
                  ->onDelete('restrict');
            
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('returns');
    }
};
