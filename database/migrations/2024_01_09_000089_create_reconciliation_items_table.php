<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reconciliation_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('bank_statement_id');
            $table->uuid('payment_id')->nullable();
            
            $table->decimal('amount', 15, 4);
            $table->string('status', 20);
            
            $table->text('notes')->nullable();
            
            $table->foreign('bank_statement_id')
                  ->references('id')
                  ->on('bank_statements')
                  ->onDelete('cascade');
            
            $table->foreign('payment_id')
                  ->references('id')
                  ->on('payments')
                  ->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reconciliation_items');
    }
};
