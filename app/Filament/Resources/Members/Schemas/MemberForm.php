<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Models\MemberType;
use App\Models\Status;
use App\Models\G12Leader;
use App\Models\Member;
use App\Models\User;
use App\Models\VipStatus;
use App\Services\CacheService;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = Auth::user();
        
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
                    ->options(CacheService::getMemberTypes())
                    ->required(),
                Select::make('status_id')
                    ->label('Status')
                    ->options(CacheService::getStatuses())
                    ->placeholder('Select status')
                    ->required(),
                Select::make('g12_leader_id')
                    ->label('G12 Leader')
                    ->options($user instanceof User ? $user->getAvailableG12Leaders() : [])
                    ->placeholder($user instanceof User && $user->isLeader() ? 'Your G12 Leader will be auto-assigned' : 'Select G12 Leader')
                    ->required($user instanceof User && $user->isAdmin()),
                Select::make('consolidator_id')
                    ->label('Consolidator')
                    ->options($user instanceof User ? $user->getAvailableConsolidators() : [])
                    ->searchable()
                    ->preload()
                    ->placeholder($user instanceof User && $user->isLeader() ? 'Select from your consolidators' : 'Select consolidator for VIP members')
                    ->helperText($user instanceof User && $user->isLeader() ? 
                        'Search and select from available consolidators in your hierarchy. Your own name will not appear in the search results.' : 
                        null),
                Select::make('vip_status_id')
                    ->label('VIP Status')
                    ->options(CacheService::getVipStatuses())
                    ->placeholder('Select VIP status')
                    ->searchable(),

                DatePicker::make('consolidation_date')
                    ->label('Date of Consolidation')
                    ->displayFormat('d/m/Y')
                    ->helperText('Date when the member accepted our Lord Jesus Christ'),
            ]);
    }
}
