<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_installments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('payment_id');
            $table->integer('installment_number');
            
            $table->decimal('amount', 15, 4);
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            
            $table->string('status', 20);
            $table->text('notes')->nullable();
            
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
        Schema::dropIfExists('payment_installments');
    }
};
