<?php

namespace App\Filament\Resources\LifeclassCandidates\Schemas;

use App\Filament\Traits\HasQualifiedMemberFields;
use App\Filament\Traits\HasLessonFormFields;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

class LifeclassCandidateForm
{
    use HasQualifiedMemberFields;
    use HasLessonFormFields;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::getQualifiedVipMemberField(),
                
                DatePicker::make('life_class_party_date')
                    ->label('Life Class Party Date')
                    ->helperText('Party date before Lesson 1 starts'),
                
                // Life Class Lesson Completion Tracking (L1-L4, Encounter, L6-L9) - Generated dynamically via trait
                ...self::generateLessonFields(4, [
                    1 => 'Lesson 1',
                    2 => 'Lesson 2',
                    3 => 'Lesson 3',
                    4 => 'Lesson 4',
                ]),
                DatePicker::make('encounter_completion_date')
                    ->label('Encounter')
                    ->displayFormat('Y-m-d')
                    ->nullable()
                    ->helperText('Life Class Encounter Session'),
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
                
                DatePicker::make('graduation_date')
                    ->label('Life Class Graduation')
                    ->helperText('Graduation ceremony date after completing all lessons'),
                
                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),
            ]);
    }
}
