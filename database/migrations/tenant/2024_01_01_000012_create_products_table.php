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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->constrained('product_categories')->cascadeOnDelete();
            $table->foreignUuid('brand_id')->nullable()->constrained('product_brands')->nullOnDelete();
            $table->string('code', 50)->unique();
            $table->string('name', 255);
            $table->string('slug', 280)->unique();
            $table->text('description')->nullable();
            $table->enum('type', ['simple', 'variant', 'service']);
            $table->enum('unit_type', ['piece', 'weight', 'length', 'volume', 'time']);
            $table->enum('tax_type', ['taxable', 'non_taxable']);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'inactive', 'discontinued'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
