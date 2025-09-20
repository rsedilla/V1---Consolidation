<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Models\MemberType;
use App\Models\Status;
use App\Models\G12Leader;
use Filament\Forms;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('middle_name')
                            ->label('Middle Name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('birthday')
                            ->label('Birthday'),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('address')
                            ->label('Address')
                            ->rows(3),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Assignment Information')
                    ->schema([
                        Forms\Components\Select::make('member_type_id')
                            ->label('Member Type')
                            ->options(MemberType::all()->pluck('name', 'id'))
                            ->required(),
                        Forms\Components\Select::make('status_id')
                            ->label('Status')
                            ->options(Status::all()->pluck('name', 'id')),
                        Forms\Components\Select::make('g12_leader_id')
                            ->label('G12 Leader')
                            ->options(G12Leader::all()->pluck('name', 'id')),
                    ])
                    ->columns(3),
            ]);
    }
}
