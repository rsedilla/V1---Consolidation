<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add 9 lesson completion date columns to track Life Class progress
     */
    public function up(): void
    {
        Schema::table('lifeclass_candidates', function (Blueprint $table) {
            $table->date('lesson_1_completion_date')->nullable()->after('qualified_date');
            $table->date('lesson_2_completion_date')->nullable()->after('lesson_1_completion_date');
            $table->date('lesson_3_completion_date')->nullable()->after('lesson_2_completion_date');
            $table->date('lesson_4_completion_date')->nullable()->after('lesson_3_completion_date');
            $table->date('encounter_completion_date')->nullable()->after('lesson_4_completion_date')->comment('Lesson 5 - Encounter');
            $table->date('lesson_6_completion_date')->nullable()->after('encounter_completion_date');
            $table->date('lesson_7_completion_date')->nullable()->after('lesson_6_completion_date');
            $table->date('lesson_8_completion_date')->nullable()->after('lesson_7_completion_date');
            $table->date('lesson_9_completion_date')->nullable()->after('lesson_8_completion_date');
            
            // Add unique constraint to prevent duplicate members
            $table->unique('member_id', 'unique_member_lifeclass_candidate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lifeclass_candidates', function (Blueprint $table) {
            $table->dropUnique('unique_member_lifeclass_candidate');
            $table->dropColumn([
                'lesson_1_completion_date',
                'lesson_2_completion_date',
                'lesson_3_completion_date',
                'lesson_4_completion_date',
                'encounter_completion_date',
                'lesson_6_completion_date',
                'lesson_7_completion_date',
                'lesson_8_completion_date',
                'lesson_9_completion_date',
            ]);
        });
    }
};
