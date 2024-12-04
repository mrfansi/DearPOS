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
            // Sections Table (for organizing tables into sections/areas)
            Schema::create('sections', function (Blueprint $table) {
                  $table->uuid('id')->primary();
                  $table->string('name');
                  $table->uuid('branch_id');
                  $table->text('description')->nullable();
                  $table->boolean('is_active')->default(true);

                  $table->timestamps();
                  $table->softDeletes();

                  $table->foreign('branch_id')
                        ->references('id')
                        ->on('branches')
                        ->cascadeOnDelete();
            });

            // Tables Table
            Schema::create('tables', function (Blueprint $table) {
                  $table->uuid('id')->primary();

                  // Identification and Location
                  $table->string('name');
                  $table->uuid('branch_id');
                  $table->uuid('section_id')->nullable();

                  // Table Characteristics
                  $table->integer('capacity');
                  $table->string('table_type', 50); // standard, vip, outdoor, private room
                  $table->string('status', 50); // available, occupied, reserved, cleaning

                  // Additional Details
                  $table->text('description')->nullable();
                  $table->boolean('is_active')->default(true);
                  $table->string('qr_code_url')->nullable();

                  // Positioning
                  $table->integer('floor_number')->nullable();
                  $table->decimal('x_coordinate', 10, 2)->nullable();
                  $table->decimal('y_coordinate', 10, 2)->nullable();

                  // Timestamps and Soft Delete
                  $table->timestamps();
                  $table->softDeletes();

                  // Foreign Key Constraints
                  $table->foreign('branch_id')
                        ->references('id')
                        ->on('branches')
                        ->cascadeOnDelete();

                  $table->foreign('section_id')
                        ->references('id')
                        ->on('sections')
                        ->nullOnDelete();
            });

            // Table Reservations Table
            Schema::create('table_reservations', function (Blueprint $table) {
                  $table->uuid('id')->primary();

                  // Reservation Identifiers
                  $table->string('reservation_number')->unique();
                  $table->uuid('customer_id')->nullable();
                  $table->uuid('table_id');
                  $table->uuid('branch_id');

                  // Timing Details
                  $table->date('reservation_date');
                  $table->dateTime('start_time');
                  $table->dateTime('end_time');

                  // Guest and Status Information
                  $table->integer('number_of_guests');
                  $table->string('status', 50); // pending, confirmed, active, completed, cancelled

                  // Additional Details
                  $table->text('special_requests')->nullable();
                  $table->decimal('deposit_amount', 15, 4)->nullable();
                  $table->decimal('total_expected_spend', 15, 4)->nullable();
                  $table->text('notes')->nullable();

                  // Creator
                  $table->uuid('created_by');

                  // Timestamps and Soft Delete
                  $table->timestamps();
                  $table->softDeletes();

                  // Foreign Key Constraints
                  $table->foreign('customer_id')
                        ->references('id')
                        ->on('customers')
                        ->nullOnDelete();

                  $table->foreign('table_id')
                        ->references('id')
                        ->on('tables')
                        ->onDelete('restrict');

                  $table->foreign('branch_id')
                        ->references('id')
                        ->on('branches')
                        ->onDelete('restrict');

                  $table->foreign('created_by')
                        ->references('id')
                        ->on('users')
                        ->onDelete('restrict');
            });
      }

      /**
       * Reverse the migrations.
       */
      public function down(): void
      {
            Schema::dropIfExists('table_reservations');
            Schema::dropIfExists('tables');
            Schema::dropIfExists('sections');
      }
};
