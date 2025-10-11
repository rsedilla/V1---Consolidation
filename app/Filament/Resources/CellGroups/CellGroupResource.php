<?php

namespace App\Filament\Resources\CellGroups;

use App\Filament\Resources\CellGroups\Pages\CreateCellGroup;
use App\Filament\Resources\CellGroups\Pages\EditCellGroup;
use App\Filament\Resources\CellGroups\Pages\ListCellGroups;
use App\Filament\Resources\CellGroups\Schemas\CellGroupForm;
use App\Filament\Resources\CellGroups\Tables\CellGroupsTable;
use App\Filament\Traits\HasNavigationBadge;
use App\Models\CellGroup;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CellGroupResource extends Resource
{
    use HasNavigationBadge;
    protected static ?string $model = CellGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Cell Groups';

    protected static ?int $navigationSort = 7;

    /**
     * Filter records based on user role and G12 leader assignment
     */
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        
        // Eager load the member and consolidator relationships to optimize database queries
        $query = parent::getEloquentQuery()->with(['member', 'member.consolidator']);
        
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            // Leaders see records for their hierarchy (including descendants)
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            return $query->whereHas('member', function ($q) use ($visibleLeaderIds) {
                $q->whereIn('g12_leader_id', $visibleLeaderIds);
            });
        }
        
        // Admins see everything, other users see nothing
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return CellGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CellGroupsTable::configure($table);
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
            'index' => ListCellGroups::route('/'),
            'create' => CreateCellGroup::route('/create'),
            'edit' => EditCellGroup::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadgeCacheKey(): string
    {
        return 'nav_badge_cellgroup';
    }
}
