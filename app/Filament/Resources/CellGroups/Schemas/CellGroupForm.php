<?php

namespace App\Filament\Resources\CellGroups\Schemas;

use App\Models\Member;
use App\Models\G12Leader;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class CellGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Cell Group Name')
                    ->required()
                    ->maxLength(255),
                Select::make('leader_id')
                    ->label('Leader')
                    ->options(Member::orderBy('first_name')->get()->mapWithKeys(function ($member) {
                        return [$member->id => $member->first_name . ' ' . $member->last_name];
                    }))
                    ->required()
                    ->searchable(),
                Select::make('g12_leader_id')
                    ->label('G12 Leader')
                    ->options(G12Leader::orderBy('name')->pluck('name', 'id'))
                    ->searchable(),
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3),
            ]);
    }
}
