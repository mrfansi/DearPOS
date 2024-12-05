<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('qris_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('payment_id');
            $table->string('qris_id', 100)->unique();
            
            $table->decimal('amount', 15, 4);
            $table->string('status', 20);
            
            $table->json('response_data')->nullable();
            
            $table->foreign('payment_id')
                  ->references('id')
                  ->on('payments')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qris_transactions');
    }
};
