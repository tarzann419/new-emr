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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id')->unique(); // Hospital-generated ID or MRN
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // If patients also login
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true); // To mark if the patient is currently active
            $table->string('profile_picture')->nullable(); // URL or path to the profile picture
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('state_of_origin')->nullable();
            $table->string('nationality')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('genotype')->nullable();
            $table->text('next_of_kin')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->string('occupation')->nullable();
            $table->text('medical_conditions')->nullable(); // Any pre-existing conditions
            $table->string('tenant_id')->nullable();

            $table->timestamps();
        });

        // fpr patient insurance
        Schema::create('patient_insurance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('insurance_company')->nullable();
            $table->string('policy_number')->nullable();
            $table->boolean('is_by_amount')->nullable();
            $table->boolean('is_by_percentage')->nullable();

            // coverage amount or percentage
            $table->decimal('coverage_amount', 10, 2)->nullable(); // Amount covered by insurance
            $table->decimal('percentage_covered', 5, 2)->nullable(); // Percentage of coverage
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('coverage_details')->nullable(); // Details about what the insurance covers
            $table->string('tenant_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
