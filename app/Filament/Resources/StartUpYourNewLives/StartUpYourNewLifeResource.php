<?php

namespace App\Filament\Resources\StartUpYourNewLives;

use App\Filament\Resources\StartUpYourNewLives\Pages\CreateStartUpYourNewLife;
use App\Filament\Resources\StartUpYourNewLives\Pages\EditStartUpYourNewLife;
use App\Filament\Resources\StartUpYourNewLives\Pages\ListStartUpYourNewLives;
use App\Filament\Resources\StartUpYourNewLives\Schemas\StartUpYourNewLifeForm;
use App\Filament\Resources\StartUpYourNewLives\Tables\StartUpYourNewLivesTable;
use App\Models\StartUpYourNewLife;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StartUpYourNewLifeResource extends Resource
{
    protected static ?string $model = StartUpYourNewLife::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'New Life Training';

    protected static ?int $navigationSort = 3;

    /**
     * Override the plural model label (used for page titles)
     */
    public static function getPluralModelLabel(): string
    {
        return 'Start Up Your New Life';
    }

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
        return StartUpYourNewLifeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StartUpYourNewLivesTable::configure($table);
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
            'index' => ListStartUpYourNewLives::route('/'),
            'create' => CreateStartUpYourNewLife::route('/create'),
            'edit' => EditStartUpYourNewLife::route('/{record}/edit'),
        ];
    }

    /**
     * Get navigation badge showing count of New Life Training records
     */
    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        
        // Cache badge count for 5 minutes per user
        $cacheKey = $user instanceof User && $user->isLeader() && $user->leaderRecord
            ? "nav_badge_newlife_leader_{$user->id}"
            : "nav_badge_newlife_admin";
        
        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 300, function () {
            // Use the same hierarchy filtering logic as the main query
            return static::getEloquentQuery()->count();
        });
    }
    
    /**
     * Clear navigation badge cache for a specific user or all users
     */
    public static function clearNavigationBadgeCache($userId = null): void
    {
        if ($userId) {
            \Illuminate\Support\Facades\Cache::forget("nav_badge_newlife_leader_{$userId}");
        } else {
            \Illuminate\Support\Facades\Cache::forget("nav_badge_newlife_admin");
        }
    }
}
