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
        Schema::create('product_audits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('auditable_type', 100);
            $table->uuid('auditable_id');
            $table->enum('event', ['created', 'updated', 'deleted', 'status_changed', 'price_changed']);
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->foreignUuid('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_audits');
    }
};
