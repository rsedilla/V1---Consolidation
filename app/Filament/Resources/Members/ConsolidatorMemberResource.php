<?php

namespace App\Filament\Resources\Members;

use App\Filament\Resources\Members\ConsolidatorMemberResource\Pages\CreateConsolidatorMember;
use App\Filament\Resources\Members\ConsolidatorMemberResource\Pages\EditConsolidatorMember;
use App\Filament\Resources\Members\ConsolidatorMemberResource\Pages\ListConsolidatorMembers;
use App\Filament\Resources\Members\Schemas\ConsolidatorMemberForm;
use App\Filament\Resources\Members\Tables\ConsolidatorMembersTable;
use App\Filament\Traits\HasMemberSearch;
use App\Filament\Traits\HasNavigationBadge;
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
    use HasMemberSearch, HasNavigationBadge;
    protected static ?string $model = Member::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Member - Consolidator';

    protected static ?string $modelLabel = 'Consolidator Member';

    protected static ?string $pluralModelLabel = 'Consolidator Members';

    protected static ?int $navigationSort = 4;

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

    protected static function getNavigationBadgeCacheKey(): string
    {
        return 'nav_badge_consolidator';
    }
}