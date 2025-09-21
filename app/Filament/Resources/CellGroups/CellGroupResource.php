<?php

namespace App\Filament\Resources\CellGroups;

use App\Filament\Resources\CellGroups\Pages\CreateCellGroup;
use App\Filament\Resources\CellGroups\Pages\EditCellGroup;
use App\Filament\Resources\CellGroups\Pages\ListCellGroups;
use App\Filament\Resources\CellGroups\Schemas\CellGroupForm;
use App\Filament\Resources\CellGroups\Tables\CellGroupsTable;
use App\Models\CellGroup;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CellGroupResource extends Resource
{
    protected static ?string $model = CellGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Cell Groups';

    protected static ?int $navigationSort = 5;

    /**
     * Filter records based on user role and G12 leader assignment
     */
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        
        if ($user instanceof User && $user->canAccessLeaderData()) {
            // Leaders see only records for their assigned members
            return parent::getEloquentQuery()->forG12Leader($user->getG12LeaderId());
        }
        
        // Admins see everything, other users see nothing
        return parent::getEloquentQuery();
    }

    public static function form(Schema $schema): Schema
    {
        return CellGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CellGroupsTable::configure($table);
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
            'index' => ListCellGroups::route('/'),
            'create' => CreateCellGroup::route('/create'),
            'edit' => EditCellGroup::route('/{record}/edit'),
        ];
    }
}
