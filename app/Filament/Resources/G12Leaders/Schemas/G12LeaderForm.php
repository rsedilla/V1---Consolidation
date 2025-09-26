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
                    ->label('Login Account (Who IS this leader)')
                    ->options(function () {
                        return User::whereIn('role', ['leader', 'admin'])
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->placeholder('Select user who represents this leader')
                    ->searchable()
                    ->preload()
                    ->helperText('Which user account IS this G12 leader (for authentication and login)'),
            ]);
    }
}