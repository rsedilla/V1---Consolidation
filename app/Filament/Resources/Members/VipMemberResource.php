<?php

namespace App\Filament\Resources\Members;

use App\Filament\Resources\Members\VipMemberResource\Pages\CreateVipMember;
use App\Filament\Resources\Members\VipMemberResource\Pages\EditVipMember;
use App\Filament\Resources\Members\VipMemberResource\Pages\ListVipMembers;
use App\Filament\Resources\Members\VipMemberResource\Pages\ViewVipMember;
use App\Filament\Resources\Members\Schemas\MemberForm;
use App\Filament\Resources\Members\Tables\VipMembersTable;
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

class VipMemberResource extends BaseMemberResource
{
    use HasMemberSearch, HasNavigationBadge;
    protected static ?string $model = Member::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Member - VIP';

    protected static ?string $modelLabel = 'VIP Member';

    protected static ?string $pluralModelLabel = 'VIP Members';

    protected static ?int $navigationSort = 3;

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

    /**
     * Apply VIP member type filter
     * Also hides members who have progressed to SOL training
     */
    protected static function applyMemberTypeFilter(Builder $query): void
    {
        $query->vips()
              ->notInSol(); // Hide members promoted to SOL 1 or higher
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

    protected static function getNavigationBadgeCacheKey(): string
    {
        return 'nav_badge_vip';
    }
}