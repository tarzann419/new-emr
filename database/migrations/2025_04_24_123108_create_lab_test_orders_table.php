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
        // loop and store based on the test types selected
        // e.g., if a test type is selected, create a record in the lab_test_orders table
        // with the test_type_id and other details
        Schema::create('lab_test_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->nullable()->constrained()->onDelete('cascade')->comment('is nullable because the test can be ordered without a consultation');
            $table->foreignId('patient_id')->nullable()->constrained()->onDelete('cascade');
            // user id of the person who ordered the test, e.g., doctor or nurse
            $table->string('ordered_by')->nullable()->comment('The user_id of the person who ordered the test, e.g., doctor or nurse');
            $table->string('test_type_id')->nullable(); // Optional, if a specific test is requested
            $table->text('notes')->nullable();
            $table->boolean('is_urgent')->default(false); // Indicates if the test is urgent
            $table->boolean('has_paid')->default(false); // Indicates if the test is urgent
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_test_orders');
    }
};
