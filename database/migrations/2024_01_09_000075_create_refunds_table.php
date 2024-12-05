<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('refund_number', 50)->unique();
            
            $table->uuid('return_id');
            $table->uuid('payment_method_id');
            
            $table->decimal('amount', 15, 4);
            $table->string('status', 20);
            
            $table->text('notes')->nullable();
            $table->uuid('refunded_by');
            
            $table->foreign('return_id')
                  ->references('id')
                  ->on('returns')
                  ->onDelete('restrict');
            
            $table->foreign('payment_method_id')
                  ->references('id')
                  ->on('payment_methods')
                  ->onDelete('restrict');
            
            $table->foreign('refunded_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('refunds');
    }
};
