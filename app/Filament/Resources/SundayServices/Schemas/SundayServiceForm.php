<?php

namespace App\Filament\Resources\SundayServices\Schemas;

use App\Models\Member;
use App\Filament\Traits\HasMemberFields;
use App\Filament\Traits\HasLessonFormFields;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class SundayServiceForm
{
    use HasMemberFields;
    use HasLessonFormFields;
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::getVipMemberFieldForSundayService(),
                
                Textarea::make('notes')
                    ->label('General Notes')
                    ->rows(2),

                // Sunday Service Session Tracking (S1-S4)
                DatePicker::make('sunday_service_1_date')
                    ->label('Sunday Service 1')
                    ->displayFormat('Y-m-d')
                    ->nullable(),
                DatePicker::make('sunday_service_2_date')
                    ->label('Sunday Service 2')
                    ->displayFormat('Y-m-d')
                    ->nullable(),
                DatePicker::make('sunday_service_3_date')
                    ->label('Sunday Service 3')
                    ->displayFormat('Y-m-d')
                    ->nullable(),
                DatePicker::make('sunday_service_4_date')
                    ->label('Sunday Service 4')
                    ->displayFormat('Y-m-d')
                    ->nullable(),
            ]);
    }
}
