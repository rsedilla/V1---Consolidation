<?php

namespace App\Filament\Traits;

use Filament\Tables\Columns\TextColumn;

trait HasLessonTableColumns
{
    /**
     * Generate lesson completion columns for Filament tables
     * 
     * This trait generates consistent lesson status columns that display:
     * - ✓ (green) if lesson is completed
     * - - (gray) if lesson is not completed
     * 
     * @param int $lessonCount Number of lessons to generate (e.g., 10 for SOL 1, 9 for Life Class)
     * @param string $columnPrefix Database column prefix (default: 'lesson_')
     * @param string $labelPrefix Display label prefix (default: 'L')
     * @return array Array of TextColumn instances
     * 
     * @example
     * // Generate 10 lesson columns (L1-L10)
     * ...self::generateLessonColumns(10),
     * 
     * @example
     * // Generate custom columns
     * ...self::generateLessonColumns(5, 'module_', 'M'),
     */
    protected static function generateLessonColumns(
        int $lessonCount,
        string $columnPrefix = 'lesson_',
        string $labelPrefix = 'L'
    ): array {
        $columns = [];
        
        for ($i = 1; $i <= $lessonCount; $i++) {
            $columns[] = TextColumn::make("{$columnPrefix}{$i}_completion_date")
                ->label("{$labelPrefix}{$i}")
                ->formatStateUsing(fn($state) => $state ? '✓' : '-')
                ->color(fn($state) => $state ? 'success' : 'gray')
                ->sortable()
                ->alignCenter();
        }
        
        return $columns;
    }
}
