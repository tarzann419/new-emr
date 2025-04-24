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
        Schema::create('lab_test_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Complete Blood Count"
            $table->string('category')->nullable(); // e.g., "Hematology", "Biochemistry"
            $table->string('code')->nullable(); // Optional internal code
            $table->text('description')->nullable(); // Short info about the test
            $table->string('sample_required')->nullable(); // e.g., "Blood", "Urine"
            $table->decimal('price', 10, 2)->nullable(); // Optional pricing
            $table->string('turnaround_time')->nullable(); // e.g., "24 hours", "2 days"
            $table->boolean('is_active')->default(true); // For toggling availability
            // tenant
            $table->string('tenant_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_test_types');
    }
};
