<?php

namespace App\Filament\Resources\LifeclassCandidates;

use App\Filament\Resources\LifeclassCandidates\Pages\CreateLifeclassCandidate;
use App\Filament\Resources\LifeclassCandidates\Pages\EditLifeclassCandidate;
use App\Filament\Resources\LifeclassCandidates\Pages\ListLifeclassCandidates;
use App\Filament\Resources\LifeclassCandidates\Schemas\LifeclassCandidateForm;
use App\Filament\Resources\LifeclassCandidates\Tables\LifeclassCandidatesTable;
use App\Filament\Traits\HasNavigationBadge;
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
    use HasNavigationBadge;
    protected static ?string $model = LifeclassCandidate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Life Class Progress';

    protected static ?string $modelLabel = 'Life Class';
    
    protected static ?string $pluralModelLabel = 'Life Class';

    protected static ?int $navigationSort = 8;

    /**
     * Filter records based on user role and G12 leader assignment
     * - Admin: See all records
     * - Equipping: See only records for assigned leader's hierarchy
     * - Leader: See records for their own hierarchy (including descendants)
     * - User: See nothing
     */
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        
        // Eager load the member relationship to optimize database queries
        $query = parent::getEloquentQuery()->with(['member']);
        
        // Hide candidates who have been promoted to SOL 1
        // (Database records preserved, they just appear in SOL 1 Progress instead)
        $query->notPromotedToSol1();
        
        if ($user instanceof User && ($user->hasLeadershipRole())) {
            // Get visible leader IDs based on role (Equipping or Leader)
            $visibleLeaderIds = $user->getVisibleLeaderIdsForFiltering();
            
            // Empty array means admin - see everything
            if (!empty($visibleLeaderIds)) {
                return $query->underLeaders($visibleLeaderIds);
            }
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

    protected static function getNavigationBadgeCacheKey(): string
    {
        return 'nav_badge_lifeclass';
    }
}
