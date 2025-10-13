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

                // Sunday Service Session Tracking (S1-S4) - Generated dynamically via trait
                ...self::generateLessonFields(4, [
                    1 => 'Sunday Service 1',
                    2 => 'Sunday Service 2',
                    3 => 'Sunday Service 3',
                    4 => 'Sunday Service 4',
                ], 'sunday_service_', ''),
            ]);
    }
}
