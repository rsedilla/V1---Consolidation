<?php

namespace App\Filament\Resources\Sol1\Schemas;

use App\Models\SolProfile;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class Sol1CandidateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('sol_profile_id')
                ->label('SOL Profile')
                ->relationship('solProfile', 'full_name')
                ->options(function () {
                    // Get SOL profiles at level 1 who don't have a candidate record yet
                    return SolProfile::whereDoesntHave('sol1Candidate')
                        ->where('current_sol_level_id', 1)
                        ->orderBy('first_name')
                        ->orderBy('last_name')
                        ->get()
                        ->pluck('full_name', 'id');
                })
                ->searchable()
                ->required()
                ->helperText('Select a SOL profile (Level 1) to track lesson progress'),
            
            DatePicker::make('enrollment_date')
                ->label('Enrollment Date')
                ->displayFormat('Y-m-d')
                ->default(now())
                ->required(),
            
            DatePicker::make('lesson_1_completion_date')
                ->label('Lesson 1')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
            DatePicker::make('lesson_2_completion_date')
                ->label('Lesson 2')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
            DatePicker::make('lesson_3_completion_date')
                ->label('Lesson 3')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
            DatePicker::make('lesson_4_completion_date')
                ->label('Lesson 4')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
            DatePicker::make('lesson_5_completion_date')
                ->label('Lesson 5')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
            DatePicker::make('lesson_6_completion_date')
                ->label('Lesson 6')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
            DatePicker::make('lesson_7_completion_date')
                ->label('Lesson 7')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
            DatePicker::make('lesson_8_completion_date')
                ->label('Lesson 8')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
            DatePicker::make('lesson_9_completion_date')
                ->label('Lesson 9')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
            DatePicker::make('lesson_10_completion_date')
                ->label('Lesson 10')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
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
