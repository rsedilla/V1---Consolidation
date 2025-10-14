<?php

namespace App\Traits;

trait HasSolLessonConfiguration
{
    /**
     * Define lesson fields for HasLessonCompletion trait
     * SOL programs have 10 lessons: L1-L10
     */
    protected function getLessonFields(): array
    {
        return [
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
        ];
    }

    /**
     * Define total lesson count for HasLessonCompletion trait
     */
    protected function getLessonCount(): int
    {
        return 10;
    }

    /**
     * Get SOL lesson casts for date fields
     * Can be used in the model's casts property
     */
    protected static function getSolLessonCasts(): array
    {
        return [
            'enrollment_date' => 'date',
            'graduation_date' => 'date',
            'lesson_1_completion_date' => 'date',
            'lesson_2_completion_date' => 'date',
            'lesson_3_completion_date' => 'date',
            'lesson_4_completion_date' => 'date',
            'lesson_5_completion_date' => 'date',
            'lesson_6_completion_date' => 'date',
            'lesson_7_completion_date' => 'date',
            'lesson_8_completion_date' => 'date',
            'lesson_9_completion_date' => 'date',
            'lesson_10_completion_date' => 'date',
        ];
    }

    /**
     * Get SOL fillable fields
     * Can be merged with model's fillable property
     */
    protected static function getSolFillableFields(): array
    {
        return [
            'sol_profile_id',
            'enrollment_date',
            'graduation_date',
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
            'notes',
        ];
    }
}
