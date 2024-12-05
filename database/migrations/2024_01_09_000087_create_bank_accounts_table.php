<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('bank_name', 100);
            $table->string('account_name', 100);
            $table->string('account_number', 50);
            
            $table->uuid('currency_id');
            
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            
            $table->foreign('currency_id')
                  ->references('id')
                  ->on('currencies')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
};
