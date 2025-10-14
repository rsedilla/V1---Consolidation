<?php

namespace App\Filament\Resources\Sol1;

use App\Filament\Resources\Sol1\Pages\CreateSol1Candidate;
use App\Filament\Resources\Sol1\Pages\EditSol1Candidate;
use App\Filament\Resources\Sol1\Pages\ListSol1Candidates;
use App\Filament\Resources\Sol1\Schemas\Sol1CandidateForm;
use App\Filament\Resources\Sol1\Tables\Sol1CandidatesTable;
use App\Filament\Traits\HasNavigationBadge;
use App\Models\Sol1Candidate;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class Sol1CandidateResource extends Resource
{
    use HasNavigationBadge;
    
    protected static ?string $model = Sol1Candidate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'SOL 1 Progress';
    
    protected static ?string $modelLabel = 'School of Leaders 1';
    
    protected static ?string $pluralModelLabel = 'School of Leaders 1';
    
    protected static string|UnitEnum|null $navigationGroup = 'Training';

    protected static ?int $navigationSort = 10;
    
    protected static ?string $slug = 'sol1-progress';

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
        
        // Eager load relationships
        $query = parent::getEloquentQuery()->with(['solProfile.status', 'solProfile.g12Leader']);
        
        // Hide candidates who have been promoted to SOL 2
        // (Database records preserved, they just appear in SOL 2 Progress instead)
        $query->notPromotedToSol2();
        
        if ($user instanceof User && ($user->hasLeadershipRole())) {
            // Get visible leader IDs based on role (Equipping or Leader)
            $visibleLeaderIds = $user->getVisibleLeaderIdsForFiltering();
            
            // Empty array means admin - see everything
            if (!empty($visibleLeaderIds)) {
                return $query->underLeaders($visibleLeaderIds);
            }
        }
        
        // Admins see everything
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return Sol1CandidateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Sol1CandidatesTable::configure($table);
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
            'index' => ListSol1Candidates::route('/'),
            'create' => CreateSol1Candidate::route('/create'),
            'edit' => EditSol1Candidate::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadgeCacheKey(): string
    {
        return 'nav_badge_sol1_candidates';
    }
}
