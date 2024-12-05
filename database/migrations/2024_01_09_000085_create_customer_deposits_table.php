<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customer_deposits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('customer_id');
            
            $table->decimal('amount', 15, 4);
            $table->decimal('used_amount', 15, 4)->default(0);
            $table->decimal('remaining_amount', 15, 4);
            
            $table->date('deposit_date');
            $table->date('expiry_date')->nullable();
            
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'used', 'expired'])->default('active');
            
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
        Schema::dropIfExists('customer_deposits');
    }
};
