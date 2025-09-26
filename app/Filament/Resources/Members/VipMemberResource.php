<?php

namespace App\Filament\Resources\Members;

use App\Filament\Resources\Members\VipMemberResource\Pages\CreateVipMember;
use App\Filament\Resources\Members\VipMemberResource\Pages\EditVipMember;
use App\Filament\Resources\Members\VipMemberResource\Pages\ListVipMembers;
use App\Filament\Resources\Members\VipMemberResource\Pages\ViewVipMember;
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
use Illuminate\Database\Eloquent\Model;
use App\Services\CacheService;

class VipMemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Member - VIP';

    protected static ?string $modelLabel = 'VIP Member';

    protected static ?string $pluralModelLabel = 'VIP Members';

    protected static ?int $navigationSort = 1;

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
            'index' => ListVipMembers::route('/'),
            'create' => CreateVipMember::route('/create'),
            'view' => ViewVipMember::route('/{record}'),
            'edit' => EditVipMember::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // Use optimized eager loading
        $query->forListing();
        
        // Filter to VIP members only
        $query->whereHas('memberType', function (Builder $query) {
            $query->where('name', 'VIP');
        });

        // Apply G12 leader filtering if user is a leader
        $user = Auth::user();
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            // Get all leader IDs in this user's hierarchy (including themselves and descendants)
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            $query->whereIn('g12_leader_id', $visibleLeaderIds);
        }

        return $query;
    }

    /**
     * Configure global search for VIP members
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return static::getEloquentQuery()
            ->with(['memberType', 'status', 'g12Leader', 'consolidator', 'vipStatus']);
    }

    /**
     * Define searchable attributes for global search
     */
    public static function getGloballySearchableAttributes(): array
    {
        return [
            'first_name',
            'last_name', 
            'email',
            'phone',
            'address',
            'memberType.name',
            'status.name',
            'g12Leader.name',
            'consolidator.first_name',
            'consolidator.last_name',
            'vipStatus.name',
        ];
    }

    /**
     * Configure global search result title
     */
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return "{$record->first_name} {$record->last_name}";
    }

    /**
     * Configure global search result details
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];
        
        if ($record->email) {
            $details[] = "Email: {$record->email}";
        }
        
        if ($record->phone) {
            $details[] = "Phone: {$record->phone}";
        }
        
        if ($record->g12Leader) {
            $details[] = "G12 Leader: {$record->g12Leader->name}";
        }
        
        if ($record->consolidator) {
            $details[] = "Consolidator: {$record->consolidator->first_name} {$record->consolidator->last_name}";
        }
        
        if ($record->vipStatus) {
            $details[] = "VIP Status: {$record->vipStatus->name}";
        }

        return $details;
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            // Use the same hierarchy filtering logic as the main query
            return static::getEloquentQuery()->count();
        }
        
        // For admin users, show total VIP count
        return Member::whereHas('memberType', function (Builder $query) {
            $query->where('name', 'VIP');
        })->count();
    }
}