<?php

namespace App\Filament\Resources\Members;

use App\Filament\Resources\Members\ConsolidatorMemberResource\Pages\CreateConsolidatorMember;
use App\Filament\Resources\Members\ConsolidatorMemberResource\Pages\EditConsolidatorMember;
use App\Filament\Resources\Members\ConsolidatorMemberResource\Pages\ListConsolidatorMembers;
use App\Filament\Resources\Members\Schemas\ConsolidatorMemberForm;
use App\Filament\Resources\Members\Tables\ConsolidatorMembersTable;
use App\Filament\Traits\HasMemberSearch;
use App\Models\Member;
use App\Models\User;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ConsolidatorMemberResource extends BaseMemberResource
{
    use HasMemberSearch;
    protected static ?string $model = Member::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Member - Consolidator';

    protected static ?string $modelLabel = 'Consolidator Member';

    protected static ?string $pluralModelLabel = 'Consolidator Members';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ConsolidatorMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConsolidatorMembersTable::configure($table);
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
            'index' => ListConsolidatorMembers::route('/'),
            'create' => CreateConsolidatorMember::route('/create'),
            'edit' => EditConsolidatorMember::route('/{record}/edit'),
        ];
    }

    /**
     * Apply Consolidator member type filter
     */
    protected static function applyMemberTypeFilter(Builder $query): void
    {
        $query->consolidators();
    }

    /**
     * Configure global search result details for Consolidator members
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = static::getBaseSearchResultDetails($record);
        
        // Add role indicator
        $details['Role'] = 'Consolidator';

        return static::formatSearchDetails($details);
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        
        // Cache badge count for 5 minutes per user
        $cacheKey = $user instanceof User && $user->leaderRecord
            ? "nav_badge_consolidator_leader_{$user->id}"
            : "nav_badge_consolidator_admin";
        
        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 300, function () use ($user) {
            if ($user instanceof User && $user->leaderRecord) {
                // Use the same hierarchy filtering logic as the main query
                return static::getEloquentQuery()->count();
            }
            
            // For admin users, show total Consolidator count (using optimized scope)
            return Member::consolidators()->count();
        });
    }
    
    /**
     * Clear navigation badge cache for a specific user or all users
     */
    public static function clearNavigationBadgeCache($userId = null): void
    {
        if ($userId) {
            \Illuminate\Support\Facades\Cache::forget("nav_badge_consolidator_leader_{$userId}");
        } else {
            \Illuminate\Support\Facades\Cache::forget("nav_badge_consolidator_admin");
        }
    }
}