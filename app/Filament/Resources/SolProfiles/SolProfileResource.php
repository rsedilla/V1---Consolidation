<?php

namespace App\Filament\Resources\SolProfiles;

use App\Filament\Resources\SolProfiles\Pages\CreateSolProfile;
use App\Filament\Resources\SolProfiles\Pages\EditSolProfile;
use App\Filament\Resources\SolProfiles\Pages\ListSolProfiles;
use App\Filament\Resources\SolProfiles\Schemas\SolProfileForm;
use App\Filament\Resources\SolProfiles\Tables\SolProfilesTable;
use App\Filament\Traits\HasNavigationBadge;
use App\Models\SolProfile;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class SolProfileResource extends Resource
{
    use HasNavigationBadge;
    
    protected static ?string $model = SolProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $navigationLabel = 'SOL Profiles';
    
    protected static string|UnitEnum|null $navigationGroup = 'Training';

    protected static ?int $navigationSort = 9;
    
    protected static ?string $slug = 'sol-profiles';

    /**
     * Filter records based on user role and G12 leader assignment
     */
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        
        // Eager load relationships to prevent lazy loading errors
        $query = parent::getEloquentQuery()->with([
            'status', 
            'g12Leader', 
            'currentSolLevel', 
            'sol1Candidate', 
            'sol2Candidate',
            'sol3Candidate'
        ]);
        
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
        return SolProfileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SolProfilesTable::configure($table);
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
            'index' => ListSolProfiles::route('/'),
            'create' => CreateSolProfile::route('/create'),
            'edit' => EditSolProfile::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationBadgeCacheKey(): string
    {
        return 'nav_badge_sol_profiles';
    }
}
