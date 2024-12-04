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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('name', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('street_address');
            $table->string('city', 100);
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100);
            
            $table->uuid('customer_id')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->string('address_type', 50)->nullable(); // e.g., 'billing', 'shipping', 'home', 'work'
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
