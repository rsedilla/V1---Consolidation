<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Models\MemberType;
use App\Models\Status;
use App\Models\G12Leader;
use App\Models\Member;
use App\Models\User;
use App\Models\VipStatus;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;

class ConsolidatorMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = Auth::user();
        
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->label('First Name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, $set, $get, $component) {
                        self::validateNameDuplication($state, $get('last_name'), $get('email'), $component);
                    }),
                TextInput::make('middle_name')
                    ->label('Middle Name')
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label('Last Name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, $set, $get, $component) {
                        self::validateNameDuplication($get('first_name'), $state, $get('email'), $component);
                    }),
                DatePicker::make('birthday')
                    ->label('Birthday'),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, $set, $get, $component) {
                        self::validateEmailDuplication($state, $get('first_name'), $get('last_name'), $component);
                    }),
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
                    ->options(Status::all()->pluck('name', 'id'))
                    ->placeholder('Select status')
                    ->required(),
                Select::make('g12_leader_id')
                    ->label('G12 Leader')
                    ->options($user instanceof User ? $user->getAvailableG12Leaders() : [])
                    ->placeholder($user instanceof User && $user->leaderRecord ? 'Your G12 Leader will be auto-assigned' : 'Select G12 Leader')
                    ->required($user instanceof User && !$user->leaderRecord),
                Select::make('consolidator_id')
                    ->label('Consolidator')
                    ->options($user instanceof User ? $user->getAvailableConsolidators() : [])
                    ->searchable()
                    ->preload()
                    ->placeholder('Not applicable for consolidators')
                    ->disabled()
                    ->dehydrated(false), // Don't include in form submission
                Select::make('vip_status_id')
                    ->label('VIP Status')
                    ->options(VipStatus::orderBy('name')->pluck('name', 'id'))
                    ->placeholder('Not applicable for consolidators')
                    ->disabled()
                    ->dehydrated(false), // Don't include in form submission
            ]);
    }

    /**
     * Validate name duplication in real-time
     */
    private static function validateNameDuplication(?string $firstName, ?string $lastName, ?string $email, $component): void
    {
        if (empty($firstName) || empty($lastName)) {
            return;
        }

        // Check for existing consolidator with same name
        $consolidatorType = MemberType::where('name', 'Consolidator')->first();
        if (!$consolidatorType) {
            return;
        }

        $existingMember = Member::where('first_name', trim($firstName))
            ->where('last_name', trim($lastName))
            ->where('member_type_id', $consolidatorType->id)
            ->with(['g12Leader'])
            ->first();

        if ($existingMember) {
            $leaderName = $existingMember->g12Leader?->name ?? 'Unknown Leader';
            $component->helperText("⚠️ A consolidator with this name already exists under {$leaderName}'s leadership.");
        } else {
            $component->helperText(null);
        }
    }

    /**
     * Validate email duplication in real-time
     */
    private static function validateEmailDuplication(?string $email, ?string $firstName, ?string $lastName, $component): void
    {
        if (empty($email)) {
            return;
        }

        // Check for existing member with same email (any member type)
        $existingMember = Member::where('email', $email)
            ->with(['memberType', 'g12Leader'])
            ->first();

        if ($existingMember) {
            $memberType = $existingMember->memberType?->name ?? 'Unknown Type';
            $leaderName = $existingMember->g12Leader?->name ?? 'Unknown Leader';
            
            $component->helperText("⚠️ This email is already used by a {$memberType} member under {$leaderName}'s leadership.");
        } else {
            $component->helperText(null);
        }
    }
}