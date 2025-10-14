<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\G12Leader;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Select::make('role')
                    ->label('Role')
                    ->options([
                        'user' => 'User',
                        'leader' => 'Leader',
                        'equipping' => 'Equipping',
                        'admin' => 'Administrator',
                    ])
                    ->default('user')
                    ->required()
                    ->helperText('Admin: Full access, Equipping: Same as Leader, Leader: Leadership privileges, User: Basic access'),
                Select::make('g12_leader_id')
                    ->label('Belongs to G12 Leader')
                    ->options(G12Leader::orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->placeholder('Select G12 Leader (optional)')
                    ->helperText('For Leaders: Links to their G12Leader record. For Equipping users: Assigns them to manage a specific leader\'s hierarchy (they will only see that leader\'s members and downline).'),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
