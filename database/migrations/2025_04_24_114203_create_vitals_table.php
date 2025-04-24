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
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('nurse_id')->nullable()->constrained()->onDelete('set null'); // The nurse who recorded it
            $table->integer('appointment_id')->nullable(); // Optional: tie to an appointment

            // Vital Measurements
            $table->float('temperature')->nullable(); // in Celsius
            $table->string('temperature_unit')->default('°C');

            $table->string('blood_pressure')->nullable(); // e.g., "120/80"
            $table->string('blood_pressure_unit')->default('mmHg');

            $table->integer('heart_rate')->nullable(); // Beats per minute
            $table->string('heart_rate_unit')->default('bpm');

            $table->integer('respiratory_rate')->nullable(); // Breaths per minute
            $table->string('respiratory_rate_unit')->default('breaths/min');

            $table->integer('oxygen_saturation')->nullable(); // in percentage
            $table->string('oxygen_saturation_unit')->default('%');

            $table->float('height')->nullable(); // in cm
            $table->string('height_unit')->default('cm');

            $table->float('weight')->nullable(); // in kg
            $table->string('weight_unit')->default('kg');

            $table->float('bmi')->nullable(); // Auto-calculated or recorded
            $table->string('bmi_unit')->default('kg/m²');

            $table->float('blood_sugar')->nullable(); // e.g., 4.5, 110 etc.
            $table->string('blood_sugar_unit')->default('mmol/L'); // or mg/dL

            // pain_score
            $table->integer('pain_score')->nullable(); // 0-10 scale

            $table->text('notes')->nullable(); // Additional nurse notes

            // tenant
            $table->string('tenant_id')->nullable(); // For multi-tenancy

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vitals');
    }
};
