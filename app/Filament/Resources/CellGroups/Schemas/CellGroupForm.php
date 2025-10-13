<?php

namespace App\Filament\Resources\CellGroups\Schemas;


use App\Models\Member;
use App\Models\G12Leader;
use App\Filament\Traits\HasMemberFields;
use App\Filament\Traits\HasLessonFormFields;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;


class CellGroupForm
{
    use HasMemberFields;
    use HasLessonFormFields;
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::getVipMemberFieldForCellGroup(),
                
                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),

                // Cell Group Session Tracking (C1-C4) - Generated dynamically via trait
                ...self::generateLessonFields(4, [
                    1 => 'Cell Group 1',
                    2 => 'Cell Group 2',
                    3 => 'Cell Group 3',
                    4 => 'Cell Group 4',
                ], 'cell_group_', 'C'),
            ]);
    }
}
