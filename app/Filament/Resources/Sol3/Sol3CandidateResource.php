<?php

namespace App\Filament\Resources\Sol3;

use App\Filament\Resources\Sol3\Pages\CreateSol3Candidate;
use App\Filament\Resources\Sol3\Pages\EditSol3Candidate;
use App\Filament\Resources\Sol3\Pages\ListSol3Candidates;
use App\Filament\Resources\Sol3\Schemas\Sol3CandidateForm;
use App\Filament\Resources\Sol3\Tables\Sol3CandidatesTable;
use App\Filament\Traits\HasNavigationBadge;
use App\Models\Sol3Candidate;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class Sol3CandidateResource extends Resource
{
    use HasNavigationBadge;
    
    protected static ?string $model = Sol3Candidate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'SOL 3 Progress';

    protected static ?string $modelLabel = 'School of Leaders 3';
    
    protected static ?string $pluralModelLabel = 'School of Leaders 3';
    
    protected static string|UnitEnum|null $navigationGroup = 'Training';

    protected static ?int $navigationSort = 12;
    
    protected static ?string $slug = 'sol3-progress';

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
        
        // Hide candidates who have been promoted to SOL Graduate
        // (Database records preserved, they just appear in SOL Graduate instead)
        $query->notPromotedToSolGrad();
        
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
        return Sol3CandidateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Sol3CandidatesTable::configure($table);
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
            'index' => ListSol3Candidates::route('/'),
            'create' => CreateSol3Candidate::route('/create'),
            'edit' => EditSol3Candidate::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadgeCacheKey(): string
    {
        return 'nav_badge_sol_3_candidates';
    }
}
