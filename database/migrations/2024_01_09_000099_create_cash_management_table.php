<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cash_management', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('session_id');
            $table->uuid('employee_id');
            
            $table->enum('transaction_type', ['cash_in', 'cash_out', 'paid_in', 'paid_out']);
            
            $table->decimal('amount', 15, 4);
            $table->text('reason')->nullable();
            $table->string('reference_number', 100)->nullable();
            
            $table->foreign('session_id')
                  ->references('id')
                  ->on('pos_sessions')
                  ->onDelete('cascade');
            
            $table->foreign('employee_id')
                  ->references('id')
                  ->on('employees')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cash_management');
    }
};
