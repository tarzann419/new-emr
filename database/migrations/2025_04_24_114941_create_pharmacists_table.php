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
        Schema::create('pharmacists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Linked to users table
            $table->string('staff_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('qualification')->nullable(); // e.g. BPharm, PharmD
            $table->string('license_number')->nullable();
            $table->string('department')->nullable(); // e.g. Outpatient, Inpatient
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('tenant_id')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacists');
    }
};
