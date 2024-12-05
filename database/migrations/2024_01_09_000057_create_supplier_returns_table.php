<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supplier_returns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('supplier_id');
            $table->uuid('goods_receipt_id')->nullable();
            
            $table->string('return_number', 50)->unique();
            $table->date('return_date');
            
            $table->string('status', 20);
            
            $table->decimal('total_amount', 15, 4);
            
            $table->text('reason')->nullable();
            $table->text('notes')->nullable();
            
            $table->uuid('created_by');
            
            $table->foreign('supplier_id')
                  ->references('id')
                  ->on('suppliers')
                  ->onDelete('restrict');
            
            $table->foreign('goods_receipt_id')
                  ->references('id')
                  ->on('goods_receipts')
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
        Schema::dropIfExists('supplier_returns');
    }
};
