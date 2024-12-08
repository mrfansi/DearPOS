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
        Schema::create('customer_audits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('auditable_type', 100);
            $table->uuid('auditable_id');
            $table->enum('event', ['created', 'updated', 'deleted', 'status_changed', 'credit_changed']);
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->foreignUuid('user_id')->constrained();
            $table->timestamp('created_at');

            $table->index(['auditable_type', 'auditable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_audits');
    }
};
