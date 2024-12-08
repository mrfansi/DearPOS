<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3)->unique();
            $table->string('name', 50);
            $table->string('symbol', 10)->nullable();
            $table->string('symbol_native', 10)->nullable();
            $table->integer('decimal_digits')->default(2);
            $table->decimal('rounding', 10, 2)->default(0);
            $table->string('name_plural', 50)->nullable();
            $table->decimal('exchange_rate', 15, 4);
            $table->timestamp('next_update_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
