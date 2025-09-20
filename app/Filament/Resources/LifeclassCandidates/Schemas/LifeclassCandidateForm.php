<?php

namespace App\Filament\Resources\LifeclassCandidates\Schemas;

use App\Models\Member;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

class LifeclassCandidateForm
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
