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
        Schema::table('start_up_your_new_life', function (Blueprint $table) {
            // Add individual lesson completion date columns
            $table->date('lesson_1_completion_date')->nullable()->after('notes');
            $table->date('lesson_2_completion_date')->nullable()->after('lesson_1_completion_date');
            $table->date('lesson_3_completion_date')->nullable()->after('lesson_2_completion_date');
            $table->date('lesson_4_completion_date')->nullable()->after('lesson_3_completion_date');
            $table->date('lesson_5_completion_date')->nullable()->after('lesson_4_completion_date');
            $table->date('lesson_6_completion_date')->nullable()->after('lesson_5_completion_date');
            $table->date('lesson_7_completion_date')->nullable()->after('lesson_6_completion_date');
            $table->date('lesson_8_completion_date')->nullable()->after('lesson_7_completion_date');
            $table->date('lesson_9_completion_date')->nullable()->after('lesson_8_completion_date');
            $table->date('lesson_10_completion_date')->nullable()->after('lesson_9_completion_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('start_up_your_new_life', function (Blueprint $table) {
            $table->dropColumn([
                'lesson_1_completion_date',
                'lesson_2_completion_date',
                'lesson_3_completion_date',
                'lesson_4_completion_date',
                'lesson_5_completion_date',
                'lesson_6_completion_date',
                'lesson_7_completion_date',
                'lesson_8_completion_date',
                'lesson_9_completion_date',
                'lesson_10_completion_date',
            ]);
        });
    }
};
