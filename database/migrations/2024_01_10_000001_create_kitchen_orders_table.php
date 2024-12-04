<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kitchen_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->uuid('station_id');
            $table->string('priority')->default('normal'); // normal, high, urgent
            $table->string('status')->default('pending'); // pending, preparing, ready, completed
            $table->timestamp('preparation_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')
                ->references('id')
                ->on('sales_transactions')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kitchen_orders');
    }
}; 