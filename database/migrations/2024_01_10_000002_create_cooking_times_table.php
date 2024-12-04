<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cooking_times', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kitchen_order_id');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->integer('duration')->nullable(); // in seconds
            $table->uuid('chef_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kitchen_order_id')
                ->references('id')
                ->on('kitchen_orders')
                ->onDelete('cascade');

            $table->foreign('chef_id')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cooking_times');
    }
}; 