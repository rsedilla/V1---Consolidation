<?php

namespace App\Filament\Resources\SundayServices;

use App\Filament\Resources\SundayServices\Pages\CreateSundayService;
use App\Filament\Resources\SundayServices\Pages\EditSundayService;
use App\Filament\Resources\SundayServices\Pages\ListSundayServices;
use App\Filament\Resources\SundayServices\Schemas\SundayServiceForm;
use App\Filament\Resources\SundayServices\Tables\SundayServicesTable;
use App\Filament\Traits\HasNavigationBadge;
use App\Models\SundayService;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SundayServiceResource extends Resource
{
    use HasNavigationBadge;
    protected static ?string $model = SundayService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Sunday Services';

    protected static ?int $navigationSort = 6;

    /**
     * Filter records based on user role and G12 leader assignment
     */
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        
        // Eager load the member and consolidator relationships to optimize database queries
        $query = parent::getEloquentQuery()->with(['member', 'member.consolidator']);
        
        // Hide members who have progressed to Life Class
        // (Database records preserved, they just appear in Life Class instead)
        $query->whereHas('member', function ($q) {
            $q->notInLifeClass();
        });
        
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
        return SundayServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SundayServicesTable::configure($table);
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
            'index' => ListSundayServices::route('/'),
            'create' => CreateSundayService::route('/create'),
            'edit' => EditSundayService::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadgeCacheKey(): string
    {
        return 'nav_badge_sunday';
    }
}
