<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('reservation_number', 50)->unique();
            
            $table->uuid('customer_id')->nullable();
            $table->uuid('pos_counter_id');
            $table->uuid('sales_transaction_id')->nullable();
            
            $table->date('reservation_date');
            $table->dateTime('reservation_time');
            $table->integer('expected_duration')->nullable();
            
            $table->string('status', 20);
            $table->integer('total_guests')->default(1);
            
            $table->text('special_requests')->nullable();
            $table->decimal('deposit_amount', 15, 4)->nullable();
            $table->text('notes')->nullable();
            
            $table->uuid('created_by');
            
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('set null');
            
            $table->foreign('pos_counter_id')
                  ->references('id')
                  ->on('pos_counters')
                  ->onDelete('restrict');
            
            $table->foreign('sales_transaction_id')
                  ->references('id')
                  ->on('sales_transactions')
                  ->onDelete('set null');
            
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
        Schema::dropIfExists('reservations');
    }
};
