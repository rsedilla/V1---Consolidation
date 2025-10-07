<?php

namespace App\Filament\Resources\Members;

use App\Filament\Resources\Members\VipMemberResource\Pages\CreateVipMember;
use App\Filament\Resources\Members\VipMemberResource\Pages\EditVipMember;
use App\Filament\Resources\Members\VipMemberResource\Pages\ListVipMembers;
use App\Filament\Resources\Members\VipMemberResource\Pages\ViewVipMember;
use App\Filament\Resources\Members\Schemas\MemberForm;
use App\Filament\Resources\Members\Tables\VipMembersTable;
use App\Filament\Traits\HasMemberSearch;
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
    use HasMemberSearch;
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
        return VipMembersTable::configure($table);
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
        
        // Filter to VIP members only (using optimized scope)
        $query->vips();

        // Apply G12 leader filtering if user is a leader
        $user = Auth::user();
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            // Get all leader IDs in this user's hierarchy (including themselves and descendants)
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            $query->underLeaders($visibleLeaderIds);
        }

        return $query;
    }

    /**
     * Extend relationship searchable attributes for VIP members
     */
    public static function getRelationshipSearchableAttributes(): array
    {
        $baseAttributes = parent::getRelationshipSearchableAttributes();
        
        return array_merge($baseAttributes, [
            'consolidator.first_name',
            'consolidator.last_name',
            'vipStatus.name',
        ]);
    }

    /**
     * Configure global search result details for VIP members
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = static::getBaseSearchResultDetails($record);
        
        if ($record->consolidator) {
            $details['Consolidator'] = "{$record->consolidator->first_name} {$record->consolidator->last_name}";
        }
        
        if ($record->vipStatus) {
            $details['VIP Status'] = $record->vipStatus->name;
        }

        return static::formatSearchDetails($details);
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
        
        // For admin users, show total VIP count (using optimized scope)
        return Member::vips()->count();
    }
}