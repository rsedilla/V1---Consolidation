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
                TextInput::make('lesson_number')
                    ->label('Lesson Number')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->maxValue(12),
                DatePicker::make('completion_date')
                    ->label('Completion Date'),
                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),
            ]);
    }
}
