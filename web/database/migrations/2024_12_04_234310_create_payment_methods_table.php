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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Basic Information
            $table->string('name');
            $table->string('code')->unique();
            $table->string('type'); // cash, card, transfer, etc.
            
            // Status and Configuration
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            
            // Advanced Payment Features
            $table->boolean('requires_reference')->default(false);
            $table->boolean('supports_installments')->default(false);
            
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
        Schema::dropIfExists('payment_methods');
    }
};
