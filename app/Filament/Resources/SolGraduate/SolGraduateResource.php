<?php

namespace App\Filament\Resources\SolGraduate;

use App\Filament\Resources\SolGraduate\Pages\ListSolGraduates;
use App\Filament\Resources\SolGraduate\Tables\SolGraduatesTable;
use App\Filament\Traits\HasNavigationBadge;
use App\Models\SolGraduate;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class SolGraduateResource extends Resource
{
    use HasNavigationBadge;
    
    protected static ?string $model = SolGraduate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $navigationLabel = 'SOL Graduate';
    
    protected static ?string $modelLabel = 'SOL Graduate';
    
    protected static ?string $pluralModelLabel = 'SOL Graduates';
    
    protected static string|UnitEnum|null $navigationGroup = 'Training';

    protected static ?int $navigationSort = 40;
    
    protected static ?string $slug = 'sol-graduate';

    /**
     * Filter records based on user role and G12 leader assignment
     * - Admin: See all graduates
     * - Equipping: See only graduates for assigned leader's hierarchy
     * - Leader: See graduates for their own hierarchy (including descendants)
     * - User: See nothing
     */
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        
        // Eager load relationships
        $query = parent::getEloquentQuery()->with(['status', 'g12Leader', 'sol3Candidate']);
        
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
        // SOL Graduates are view-only, no form needed
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return SolGraduatesTable::configure($table);
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
            'index' => ListSolGraduates::route('/'),
        ];
    }

    protected static function getNavigationBadgeCacheKey(): string
    {
        return 'nav_badge_sol_graduates';
    }

    /**
     * Disable create action since graduates are promoted from SOL 3
     */
    public static function canCreate(): bool
    {
        return false;
    }
}
