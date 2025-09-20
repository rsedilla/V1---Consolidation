<?php

namespace App\Filament\Resources\SundayServices\Schemas;

use App\Models\Member;
use App\Filament\Traits\HasMemberFields;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class SundayServiceForm
{
    use HasMemberFields;
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::getVipMemberField(),
                
                Textarea::make('notes')
                    ->label('General Notes')
                    ->rows(2),

                // Sunday Service Session Tracking
                DatePicker::make('sunday_service_1_date')
                    ->label('Sunday Service 1'),
                DatePicker::make('sunday_service_2_date')
                    ->label('Sunday Service 2'),
                DatePicker::make('sunday_service_3_date')
                    ->label('Sunday Service 3'),
                DatePicker::make('sunday_service_4_date')
                    ->label('Sunday Service 4'),
            ]);
    }
}
