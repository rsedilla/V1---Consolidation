<?php

namespace App\Filament\Resources\Sol1\Schemas;

use App\Models\G12Leader;
use App\Models\Status;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class Sol1Form
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
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
            
            DatePicker::make('birthday')
                ->label('Birthday')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
            DatePicker::make('wedding_anniversary_date')
                ->label('Wedding Anniversary')
                ->displayFormat('Y-m-d')
                ->nullable(),
            
            Textarea::make('address')
                ->label('Address')
                ->rows(3)
                ->maxLength(65535),
            
            Select::make('status_id')
                ->label('Status')
                ->relationship('status', 'name')
                ->options(Status::pluck('name', 'id'))
                ->searchable()
                ->required(),
            
            Select::make('g12_leader_id')
                ->label('G12 Leader')
                ->relationship('g12Leader', 'name')
                ->options(function () {
                    $user = Auth::user();
                    
                    if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
                        // Leaders see themselves and their descendants
                        $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
                        return G12Leader::whereIn('id', $visibleLeaderIds)
                            ->orderBy('name')
                            ->get()
                            ->pluck('name', 'id');
                    }
                    
                    // Admins see all leaders
                    return G12Leader::orderBy('name')
                        ->get()
                        ->pluck('name', 'id');
                })
                ->searchable()
                ->required(),
            
            Toggle::make('is_cell_leader')
                ->label('Is Cell Leader')
                ->default(false),
            
            Select::make('member_id')
                ->label('Linked Member (Optional)')
                ->relationship('member', 'full_name')
                ->searchable()
                ->nullable()
                ->helperText('Link to an existing Member VIP record if applicable'),
            
            Textarea::make('notes')
                ->label('Notes')
                ->rows(4)
                ->maxLength(65535),
        ]);
    }
}
