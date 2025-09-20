<?php

namespace App\Filament\Resources\StartUpYourNewLives\Schemas;

use App\Models\Member;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

class StartUpYourNewLifeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('member_id')
                    ->label('Member')
                    ->options(Member::orderBy('first_name')->get()->mapWithKeys(function ($member) {
                        return [$member->id => $member->first_name . ' ' . $member->last_name];
                    }))
                    ->required()
                    ->searchable(),
                
                Textarea::make('notes')
                    ->label('General Notes')
                    ->rows(2),

                // Lesson Completion Tracking
                DatePicker::make('lesson_1_completion_date')
                    ->label('Lesson 1: Assurance of Salvation'),
                DatePicker::make('lesson_2_completion_date')
                    ->label('Lesson 2: Assurance of Answer Prayer'),
                DatePicker::make('lesson_3_completion_date')
                    ->label('Lesson 3: Assurance of Victory'),
                DatePicker::make('lesson_4_completion_date')
                    ->label('Lesson 4: Assurance of Forgiveness'),
                DatePicker::make('lesson_5_completion_date')
                    ->label('Lesson 5: Assurance of Guidance'),
                DatePicker::make('lesson_6_completion_date')
                    ->label('Lesson 6: The Spirit-Filled Life'),
                DatePicker::make('lesson_7_completion_date')
                    ->label('Lesson 7: Walking in the Spirit'),
                DatePicker::make('lesson_8_completion_date')
                    ->label('Lesson 8: Witnessing in the Spirit'),
                DatePicker::make('lesson_9_completion_date')
                    ->label('Lesson 9: Spiritual Breathing'),
                DatePicker::make('lesson_10_completion_date')
                    ->label('Lesson 10: Understanding the Bible'),

                // Legacy fields (hidden for new records, visible for existing)
                TextInput::make('lesson_number')
                    ->label('Legacy Lesson Number')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(10)
                    ->hidden(fn ($record) => $record === null), // Hide on create
                DatePicker::make('completion_date')
                    ->label('Legacy Completion Date')
                    ->hidden(fn ($record) => $record === null), // Hide on create
            ]);
    }
}
