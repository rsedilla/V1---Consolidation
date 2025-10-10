<?php

namespace App\Filament\Resources\LifeclassCandidates\Schemas;

use App\Filament\Traits\HasMemberFields;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

class LifeclassCandidateForm
{
    use HasMemberFields;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::getQualifiedVipMemberField(),
                
                DatePicker::make('qualified_date')
                    ->label('Qualified Date')
                    ->helperText('Date when VIP met all requirements for Life Class'),
                
                // Life Class Lesson Completion Tracking
                DatePicker::make('lesson_1_completion_date')
                    ->label('Lesson 1'),
                DatePicker::make('lesson_2_completion_date')
                    ->label('Lesson 2'),
                DatePicker::make('lesson_3_completion_date')
                    ->label('Lesson 3'),
                DatePicker::make('lesson_4_completion_date')
                    ->label('Lesson 4'),
                DatePicker::make('encounter_completion_date')
                    ->label('Encounter')
                    ->helperText('Life Class Encounter Session'),
                DatePicker::make('lesson_6_completion_date')
                    ->label('Lesson 6'),
                DatePicker::make('lesson_7_completion_date')
                    ->label('Lesson 7'),
                DatePicker::make('lesson_8_completion_date')
                    ->label('Lesson 8'),
                DatePicker::make('lesson_9_completion_date')
                    ->label('Lesson 9'),
                
                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),
            ]);
    }
}
