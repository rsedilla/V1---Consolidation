<?php

namespace App\Filament\Resources\G12Leaders\Schemas;

use App\Models\G12Leader;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class G12LeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Leader Name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->placeholder('Enter G12 leader name'),

                Select::make('parent_id')
                    ->label('Parent Leader (Optional)')
                    ->options(function () {
                        return G12Leader::orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->placeholder('Select parent leader (optional)')
                    ->searchable()
                    ->preload()
                    ->helperText('Select a parent leader to create hierarchy structure'),

                Select::make('user_id')
                    ->label('User Account (Optional)')
                    ->options(function () {
                        return User::whereDoesntHave('leaderRecord')
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->placeholder('Link to user account (optional)')
                    ->searchable()
                    ->preload()
                    ->helperText('Link this leader to a user account for login access'),
            ]);
    }
}