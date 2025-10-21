<?php

namespace App\Filament\Resources\Sol1\Schemas;

use App\Filament\Traits\HasLessonFormFields;
use App\Models\SolProfile;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class Sol1CandidateForm
{
    use HasLessonFormFields;
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('sol_profile_id')
                ->label('SOL Profile')
                ->relationship('solProfile', 'full_name')
                ->options(function ($record) {
                    // When editing, just show current profile (no search needed)
                    if ($record && $record->sol_profile_id) {
                        return [$record->sol_profile_id => $record->solProfile->full_name];
                    }
                    // When creating, load available profiles with search
                    // Get SOL 1 level ID dynamically
                    $sol1Level = \App\Models\SolLevel::where('level_number', 1)->first();
                    
                    if (!$sol1Level) {
                        return [];
                    }
                    
                    return SolProfile::whereDoesntHave('sol1Candidate')
                        ->where('current_sol_level_id', $sol1Level->id)
                        ->orderBy('first_name')
                        ->orderBy('last_name')
                        ->get()
                        ->pluck('full_name', 'id');
                })
                ->searchable(fn ($record) => !$record) // Only searchable when creating
                ->disabled(fn ($record) => (bool) $record) // Disabled when editing
                ->required()
                ->helperText('Select a SOL profile (Level 1) to track lesson progress'),
            
            DatePicker::make('enrollment_date')
                ->label('Enrollment Date')
                ->displayFormat('Y-m-d')
                ->default(now())
                ->required(),
            
            // SOL 1 Lesson Fields (L1-L10)
            ...self::generateLessonFields(10, [
                1 => 'Lesson 1',
                2 => 'Lesson 2',
                3 => 'Lesson 3',
                4 => 'Lesson 4',
                5 => 'Lesson 5',
                6 => 'Lesson 6',
                7 => 'Lesson 7',
                8 => 'Lesson 8',
                9 => 'Lesson 9',
                10 => 'Lesson 10',
            ]),
            
            DatePicker::make('graduation_date')
                ->label('Graduation Date')
                ->displayFormat('Y-m-d')
                ->nullable()
                ->helperText('Set when all 10 lessons are completed'),
            
            Textarea::make('notes')
                ->label('Notes')
                ->rows(4)
                ->maxLength(65535),
        ]);
    }
}
