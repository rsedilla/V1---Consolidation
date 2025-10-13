<?php

namespace App\Filament\Traits;

use Filament\Forms\Components\DatePicker;

trait HasLessonFormFields
{
    /**
     * Generate lesson completion date fields for Filament forms
     * 
     * This trait generates consistent DatePicker fields for lesson tracking.
     * Each field is nullable and uses 'Y-m-d' format.
     * 
     * @param int $lessonCount Number of lesson fields to generate
     * @param array $lessonLabels Optional custom labels for each lesson (indexed from 1)
     * @param string $fieldPrefix Database field prefix (default: 'lesson_')
     * @param string $labelPrefix Display label prefix (default: 'Lesson ')
     * @return array Array of DatePicker instances
     * 
     * @example
     * // Generate 10 basic lesson fields (Lesson 1 - Lesson 10)
     * ...self::generateLessonFields(10),
     * 
     * @example
     * // Generate 10 fields with custom labels
     * ...self::generateLessonFields(10, [
     *     1 => 'Lesson 1: Salvation',
     *     2 => 'Lesson 2: Repentance',
     *     // ... etc
     * ]),
     */
    protected static function generateLessonFields(
        int $lessonCount,
        array $lessonLabels = [],
        string $fieldPrefix = 'lesson_',
        string $labelPrefix = 'Lesson '
    ): array {
        $fields = [];
        
        for ($i = 1; $i <= $lessonCount; $i++) {
            // Use custom label if provided, otherwise use default pattern
            $label = $lessonLabels[$i] ?? "{$labelPrefix}{$i}";
            
            $fields[] = DatePicker::make("{$fieldPrefix}{$i}_completion_date")
                ->label($label)
                ->displayFormat('Y-m-d')
                ->nullable();
        }
        
        return $fields;
    }
}
