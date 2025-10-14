<?php

namespace App\Filament\Resources\Sol2;

use App\Filament\Resources\Sol2\Pages\CreateSol2Candidate;
use App\Filament\Resources\Sol2\Pages\EditSol2Candidate;
use App\Filament\Resources\Sol2\Pages\ListSol2Candidates;
use App\Filament\Resources\Sol2\Schemas\Sol2CandidateForm;
use App\Filament\Resources\Sol2\Tables\Sol2CandidatesTable;
use App\Filament\Traits\HasNavigationBadge;
use App\Models\Sol2Candidate;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class Sol2CandidateResource extends Resource
{
    use HasNavigationBadge;
    
    protected static ?string $model = Sol2Candidate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'SOL 2 Progress';

    protected static ?string $modelLabel = 'School of Leaders 2';
    
    protected static ?string $pluralModelLabel = 'School of Leaders 2';
    
    protected static string|UnitEnum|null $navigationGroup = 'Training';

    protected static ?int $navigationSort = 11;
    
    protected static ?string $slug = 'sol2-progress';

    /**
     * Filter records based on user role and G12 leader assignment
     */
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        
        // Eager load relationships
        $query = parent::getEloquentQuery()->with(['solProfile.status', 'solProfile.g12Leader']);
        
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            // Leaders see records for their hierarchy (including descendants)
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            return $query->underLeaders($visibleLeaderIds);
        }
        
        // Admins see everything
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return Sol2CandidateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Sol2CandidatesTable::configure($table);
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
            'index' => ListSol2Candidates::route('/'),
            'create' => CreateSol2Candidate::route('/create'),
            'edit' => EditSol2Candidate::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadgeCacheKey(): string
    {
        return 'nav_badge_sol2_candidates';
    }
}
