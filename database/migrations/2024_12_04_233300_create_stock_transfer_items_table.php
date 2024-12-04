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
            Schema::create('stock_transfer_items', function (Blueprint $table) {
                  $table->uuid('id')->primary();

                  $table->uuid('transfer_id');
                  $table->uuid('product_id');
                  $table->uuid('variant_id')->nullable();

                  $table->decimal('quantity', 15, 4);
                  $table->uuid('unit_id');

                  $table->uuid('from_location_id');
                  $table->uuid('to_location_id');

                  $table->text('notes')->nullable();

                  $table->timestamps();
                  $table->softDeletes();

                  // Foreign key constraints
                  $table->foreign('transfer_id')
                        ->references('id')
                        ->on('stock_transfers')
                        ->cascadeOnDelete();

                  $table->foreign('product_id')
                        ->references('id')
                        ->on('products')
                        ->cascadeOnDelete();

                  $table->foreign('variant_id')
                        ->references('id')
                        ->on('product_variants')
                        ->cascadeOnDelete();

                  $table->foreign('unit_id')
                        ->references('id')
                        ->on('units_of_measures')
                        ->onDelete('restrict');

                  $table->foreign('from_location_id')
                        ->references('id')
                        ->on('storage_locations')
                        ->onDelete('restrict');

                  $table->foreign('to_location_id')
                        ->references('id')
                        ->on('storage_locations')
                        ->onDelete('restrict');
            });
      }

      /**
       * Reverse the migrations.
       */
      public function down(): void
      {
            Schema::dropIfExists('stock_transfer_items');
      }
};
