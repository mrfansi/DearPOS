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
            $table->string('qris_reference_number', 100);
            $table->string('merchant_id', 50);
            $table->string('terminal_id', 50);
            $table->decimal('amount', 15, 4);
            $table->enum('status', ['pending', 'success', 'failed', 'reversed'])->default('pending');
            $table->timestamp('transaction_time')->nullable();
            $table->text('response_payload')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    public function down()
    {
        Schema::dropIfExists('qris_transactions');
    }
};
