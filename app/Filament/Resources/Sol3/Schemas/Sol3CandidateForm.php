<?php

namespace App\Filament\Resources\Sol3\Schemas;

use App\Filament\Traits\HasLessonFormFields;
use App\Models\SolProfile;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class Sol3CandidateForm
{
    use HasLessonFormFields;
    
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('sol_profile_id')
                ->label('SOL Profile')
                ->relationship('solProfile', 'full_name')
                ->options(function () {
                    // Get SOL profiles at level 3 who don't have a candidate record yet
                    return SolProfile::whereDoesntHave('sol3Candidate')
                        ->where('current_sol_level_id', 3)
                        ->orderBy('first_name')
                        ->orderBy('last_name')
                        ->get()
                        ->pluck('full_name', 'id');
                })
                ->searchable()
                ->required()
                ->helperText('Select a SOL profile (Level 3) to track lesson progress'),
            
            DatePicker::make('enrollment_date')
                ->label('Enrollment Date')
                ->displayFormat('Y-m-d')
                ->default(now())
                ->required(),
            
            // SOL 3 Lesson Fields (L1-L10)
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
