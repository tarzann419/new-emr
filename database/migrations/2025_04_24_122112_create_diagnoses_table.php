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
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade');
            $table->string('code')->nullable(); // ICD-10/11 or internal
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('provisional_diagnosis')->nullable();
            $table->text('confirmed_diagnosis')->nullable();
            $table->text('differential_diagnosis')->nullable();
            $table->string('severity')->nullable(); // e.g. mild, moderate, severe
            $table->enum('type', ['primary', 'secondary'])->default('primary');
            // tenant_id is not needed here as it can be derived from the consultation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};
