<?php

namespace App\Filament\Resources\LifeclassCandidates;

use App\Filament\Resources\LifeclassCandidates\Pages\CreateLifeclassCandidate;
use App\Filament\Resources\LifeclassCandidates\Pages\EditLifeclassCandidate;
use App\Filament\Resources\LifeclassCandidates\Pages\ListLifeclassCandidates;
use App\Filament\Resources\LifeclassCandidates\Schemas\LifeclassCandidateForm;
use App\Filament\Resources\LifeclassCandidates\Tables\LifeclassCandidatesTable;
use App\Models\LifeclassCandidate;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LifeclassCandidateResource extends Resource
{
    protected static ?string $model = LifeclassCandidate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Life Class Candidates';

    protected static ?int $navigationSort = 6;

    /**
     * Filter records based on user role and G12 leader assignment
     */
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        
        // Eager load the member relationship to optimize database queries
        $query = parent::getEloquentQuery()->with(['member']);
        
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            // Leaders see records for their hierarchy (including descendants)
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            return $query->underLeaders($visibleLeaderIds);
        }
        
        // Admins see everything, other users see nothing
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return LifeclassCandidateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LifeclassCandidatesTable::configure($table);
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
            'index' => ListLifeclassCandidates::route('/'),
            'create' => CreateLifeclassCandidate::route('/create'),
            'edit' => EditLifeclassCandidate::route('/{record}/edit'),
        ];
    }

    /**
     * Get navigation badge showing count of Life Class Candidate records
     */
    public static function getNavigationBadge(): ?string
    {
        $user = Auth::user();
        
        // Cache badge count for 5 minutes per user
        $cacheKey = $user instanceof User && $user->isLeader() && $user->leaderRecord
            ? "nav_badge_lifeclass_leader_{$user->id}"
            : "nav_badge_lifeclass_admin";
        
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
            \Illuminate\Support\Facades\Cache::forget("nav_badge_lifeclass_leader_{$userId}");
        } else {
            \Illuminate\Support\Facades\Cache::forget("nav_badge_lifeclass_admin");
        }
    }
}
