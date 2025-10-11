<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * SOL 1 Candidates - Tracks lesson completion for SOL 1 students
     * Similar to lifeclass_candidates table
     */
    public function up(): void
    {
        Schema::create('sol_1_candidates', function (Blueprint $table) {
            $table->id();
            
            // Link to SOL 1 main record
            $table->foreignId('sol_1_id')->constrained('sol_1')->onDelete('cascade');
            
            // Dates
            $table->date('enrollment_date');
            $table->date('graduation_date')->nullable();
            
            // SOL 1 Lesson Tracking (10 lessons)
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
            $table->index('sol_1_id');
            $table->index('enrollment_date');
            $table->index('graduation_date');
            
            // Unique constraint - one candidate record per SOL 1 student
            $table->unique('sol_1_id', 'unique_sol1_candidate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sol_1_candidates');
    }
};
