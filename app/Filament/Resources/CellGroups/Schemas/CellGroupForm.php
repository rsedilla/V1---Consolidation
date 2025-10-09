<?php

namespace App\Filament\Resources\CellGroups\Schemas;

use App\Models\Member;
use App\Models\G12Leader;
use App\Filament\Traits\HasMemberFields;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;

class CellGroupForm
{
    use HasMemberFields;
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::getVipMemberFieldForCellGroup(),
                
                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),

                // Cell Group Session Tracking
                DatePicker::make('cell_group_1_date')
                    ->label('Cell Group 1'),
                DatePicker::make('cell_group_2_date')
                    ->label('Cell Group 2'),
                DatePicker::make('cell_group_3_date')
                    ->label('Cell Group 3'),
                DatePicker::make('cell_group_4_date')
                    ->label('Cell Group 4'),
            ]);
    }
}
