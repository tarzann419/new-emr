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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('vital_id')->nullable()->constrained()->onDelete('set null'); // Optional

            // Appointment Details
            $table->enum('status', ['pending', 'checked_in', 'in_consultation', 'completed', 'cancelled'])->default('pending');
            $table->enum('appointment_type', ['consultation', 'follow-up', 'emergency', 'admission', 'test'])->default('consultation');
            $table->dateTime('scheduled_at');
            $table->dateTime('checked_in_at')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();

            $table->text('reason')->nullable(); // Reason for appointment (provided by patient or front desk)
            $table->text('notes')->nullable(); // Internal notes or remarks

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
