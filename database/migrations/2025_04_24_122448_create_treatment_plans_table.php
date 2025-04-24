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
        Schema::create('treatment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained()->onDelete('cascade');
            $table->text('description');
            $table->string('duration')->nullable(); // e.g., "7 days"
            $table->string('side_effects')->nullable(); // e.g., "7 days"
            $table->text('special_instructions')->nullable(); 
            $table->text('follow_up')->nullable(); // e.g., "Follow up in 2 weeks"

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatment_plans');
    }
};
