<?php

namespace App\Filament\Resources\Members;

use App\Filament\Resources\Members\ConsolidatorMemberResource\Pages\CreateConsolidatorMember;
use App\Filament\Resources\Members\ConsolidatorMemberResource\Pages\EditConsolidatorMember;
use App\Filament\Resources\Members\ConsolidatorMemberResource\Pages\ListConsolidatorMembers;
use App\Filament\Resources\Members\Schemas\ConsolidatorMemberForm;
use App\Filament\Resources\Members\Tables\ConsolidatorMembersTable;
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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // Use optimized eager loading
        $query->forListing();
        
        // Filter to Consolidator members only
        $query->whereHas('memberType', function (Builder $query) {
            $query->where('name', 'Consolidator');
        });

        // Apply G12 leader filtering if user is a leader
        $user = Auth::user();
        if ($user instanceof User && $user->leaderRecord) {
            // Get all leader IDs in this user's hierarchy (including themselves and descendants)
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            $query->whereIn('g12_leader_id', $visibleLeaderIds);
        }

        return $query;
    }

    /**
     * Configure global search for Consolidator members
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return static::getEloquentQuery()
            ->with(['memberType', 'status', 'g12Leader']);
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
        
        $details[] = "Role: Consolidator";

        return $details;
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        
        if ($user instanceof User && $user->leaderRecord) {
            // Use the same hierarchy filtering logic as the main query
            return static::getEloquentQuery()->count();
        }
        
        // For admin users, show total Consolidator count
        return Member::whereHas('memberType', function (Builder $query) {
            $query->where('name', 'Consolidator');
        })->count();
    }
}