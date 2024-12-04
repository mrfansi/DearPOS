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
        Schema::create('expiry_alerts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('product_id');
            $table->uuid('variant_id')->nullable();
            $table->uuid('lot_id')->nullable();

            $table->integer('days_before_expiry');
            $table->boolean('is_active')->default(true);

            $table->timestamp('last_triggered_at')->nullable();
            $table->uuid('created_by');

            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->foreign('variant_id')
                ->references('id')
                ->on('product_variants')
                ->onDelete('cascade');

            $table->foreign('lot_id')
                ->references('id')
                ->on('inventory_lots')
                ->onDelete('cascade');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            // Unique constraint for expiry alert configuration
            $table->unique(['product_id', 'variant_id', 'lot_id', 'days_before_expiry'], 'expiry_alert_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expiry_alerts');
    }
};
