<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Identification and Exchange Rate
            $table->string('code', 3)->unique(); // 3-letter currency code
            $table->string('name', 50); // Full name of the currency
            $table->decimal('exchange_rate', 15, 4); // Current exchange rate
            
            // Timestamps and Soft Delete
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
