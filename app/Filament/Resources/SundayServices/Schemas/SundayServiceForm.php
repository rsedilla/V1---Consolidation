<?php

namespace App\Filament\Resources\SundayServices\Schemas;

use App\Models\Member;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;

class SundayServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('member_id')
                    ->label('Member')
                    ->options(Member::all()->pluck('first_name', 'id'))
                    ->required()
                    ->searchable(),
                DatePicker::make('service_date')
                    ->label('Service Date')
                    ->required(),
                TextInput::make('attendance_status')
                    ->label('Attendance Status')
                    ->default('present'),
            ]);
    }
}
