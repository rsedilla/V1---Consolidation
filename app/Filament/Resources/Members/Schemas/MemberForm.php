<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Models\MemberType;
use App\Models\Status;
use App\Models\G12Leader;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->label('First Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('middle_name')
                    ->label('Middle Name')
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label('Last Name')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('birthday')
                    ->label('Birthday'),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->maxLength(255),
                Textarea::make('address')
                    ->label('Address')
                    ->rows(3),
                Select::make('member_type_id')
                    ->label('Member Type')
                    ->options(MemberType::all()->pluck('name', 'id'))
                    ->required(),
                Select::make('status_id')
                    ->label('Status')
                    ->options(Status::all()->pluck('name', 'id')),
                Select::make('g12_leader_id')
                    ->label('G12 Leader')
                    ->options(G12Leader::orderBy('name')->pluck('name', 'id')),
                TextInput::make('consolidator')
                    ->label('Consolidator')
                    ->maxLength(255)
                    ->placeholder('Enter consolidator name for VIP members'),
            ]);
    }
}
