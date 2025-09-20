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
                DatePicker::make('application_date')
                    ->label('Application Date')
                    ->default(now()),
                Select::make('qualification_status')
                    ->label('Qualification Status')
                    ->options([
                        'pending' => 'Pending',
                        'qualified' => 'Qualified',
                        'not_qualified' => 'Not Qualified',
                    ])
                    ->default('pending'),
                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),
            ]);
    }
}
