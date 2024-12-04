<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->uuid('driver_id')->nullable();
            $table->text('delivery_address');
            $table->decimal('delivery_fee', 15, 2);
            $table->timestamp('estimated_time')->nullable();
            $table->timestamp('actual_time')->nullable();
            $table->string('status')->default('pending'); // pending, assigned, picked_up, delivered, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')
                ->references('id')
                ->on('sales_transactions')
                ->onDelete('cascade');

            $table->foreign('driver_id')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_orders');
    }
}; 