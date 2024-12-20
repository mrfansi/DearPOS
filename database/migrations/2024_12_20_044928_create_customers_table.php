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
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('group_id')->nullable()->constrained('customer_groups')->onDelete('set null');
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->string('email', 100)->nullable()->unique();
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('tax_number', 50)->nullable();
            $table->decimal('credit_limit', 15, 4)->default(0);
            $table->decimal('current_balance', 15, 4)->default(0);
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive', 'blocked']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
