<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_alerts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            $table->uuid('warehouse_id');
            $table->enum('alert_type', ['low_stock', 'overstock', 'expiring']);
            $table->decimal('threshold_quantity', 15, 4)->nullable(); // Made nullable for expiring alerts
            $table->decimal('current_quantity', 15, 4);
            $table->enum('status', ['active', 'resolved', 'ignored']);
            $table->boolean('is_notification_sent')->default(false);
            $table->timestamp('notification_date')->nullable();
            $table->uuid('resolved_by')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('product_variant_id')->references('id')->on('product_variants');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('resolved_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_alerts');
    }
};
