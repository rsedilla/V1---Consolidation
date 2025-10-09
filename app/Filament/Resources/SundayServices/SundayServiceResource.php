<?php

namespace App\Filament\Resources\SundayServices;

use App\Filament\Resources\SundayServices\Pages\CreateSundayService;
use App\Filament\Resources\SundayServices\Pages\EditSundayService;
use App\Filament\Resources\SundayServices\Pages\ListSundayServices;
use App\Filament\Resources\SundayServices\Schemas\SundayServiceForm;
use App\Filament\Resources\SundayServices\Tables\SundayServicesTable;
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
    protected static ?string $model = SundayService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Sunday Services';

    protected static ?int $navigationSort = 4;

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

    /**
     * Get navigation badge showing count of Sunday Service records
     */
    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        
        // Cache badge count for 5 minutes per user
        $cacheKey = $user instanceof User && $user->isLeader() && $user->leaderRecord
            ? "nav_badge_sunday_leader_{$user->id}"
            : "nav_badge_sunday_admin";
        
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
            \Illuminate\Support\Facades\Cache::forget("nav_badge_sunday_leader_{$userId}");
        } else {
            \Illuminate\Support\Facades\Cache::forget("nav_badge_sunday_admin");
        }
    }
}
