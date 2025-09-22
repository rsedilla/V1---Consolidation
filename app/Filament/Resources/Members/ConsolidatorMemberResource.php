<?php

namespace App\Filament\Resources\Members;

use App\Filament\Resources\Members\Pages\CreateMember;
use App\Filament\Resources\Members\Pages\EditMember;
use App\Filament\Resources\Members\Pages\ListMembers;
use App\Filament\Resources\Members\Schemas\MemberForm;
use App\Filament\Resources\Members\Tables\MembersTable;
use App\Models\Member;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ConsolidatorMemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Member - Consolidator';

    protected static ?string $modelLabel = 'Consolidator Member';

    protected static ?string $pluralModelLabel = 'Consolidator Members';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return MemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MembersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMembers::route('/'),
            'create' => CreateMember::route('/create'),
            'edit' => EditMember::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // Filter to Consolidator members only
        $query->whereHas('memberType', function (Builder $query) {
            $query->where('name', 'Consolidator');
        });

        // Apply G12 leader filtering if user is a leader
        $user = Auth::user();
        if ($user instanceof User && $user->canAccessLeaderData()) {
            $g12LeaderId = $user->getG12LeaderId();
            if ($g12LeaderId) {
                $query->where('g12_leader_id', $g12LeaderId);
            }
        }

        return $query;
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        
        if ($user instanceof User && $user->canAccessLeaderData()) {
            $g12LeaderId = $user->getG12LeaderId();
            if ($g12LeaderId) {
                return static::getEloquentQuery()->count();
            }
        }
        
        // For admin users, show total Consolidator count
        return Member::whereHas('memberType', function (Builder $query) {
            $query->where('name', 'Consolidator');
        })->count();
    }
}