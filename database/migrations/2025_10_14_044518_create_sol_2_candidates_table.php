<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * SOL 2 Candidates - Tracks lesson completion for SOL 2 students
     * Students progress to SOL 2 after completing SOL 1
     */
    public function up(): void
    {
        Schema::create('sol_2_candidates', function (Blueprint $table) {
            $table->id();
            
            // Link to SOL Profile
            $table->foreignId('sol_profile_id')->constrained('sol_profiles')->onDelete('cascade');
            
            // Dates
            $table->date('enrollment_date');
            $table->date('graduation_date')->nullable();
            
            // SOL 2 Lesson Tracking (10 lessons)
            $table->date('lesson_1_completion_date')->nullable();
            $table->date('lesson_2_completion_date')->nullable();
            $table->date('lesson_3_completion_date')->nullable();
            $table->date('lesson_4_completion_date')->nullable();
            $table->date('lesson_5_completion_date')->nullable();
            $table->date('lesson_6_completion_date')->nullable();
            $table->date('lesson_7_completion_date')->nullable();
            $table->date('lesson_8_completion_date')->nullable();
            $table->date('lesson_9_completion_date')->nullable();
            $table->date('lesson_10_completion_date')->nullable();
            
            // Notes
            $table->text('notes')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('sol_profile_id');
            $table->index('enrollment_date');
            $table->index('graduation_date');
            
            // Unique constraint - one candidate record per SOL profile at SOL 2 level
            $table->unique('sol_profile_id', 'unique_sol2_candidate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sol_2_candidates');
    }
};
